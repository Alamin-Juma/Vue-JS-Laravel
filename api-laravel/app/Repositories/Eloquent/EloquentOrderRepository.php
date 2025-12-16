<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\Enums\CommissionTier;
use App\Enums\UserType;
use App\Repositories\Contracts\OrderRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * Eloquent implementation of OrderRepository.
 *
 * Actual database schema:
 * - orders: id, invoice_number, purchaser_id, order_date
 * - users: id, first_name, last_name, username, referred_by, enrolled_date
 * - user_category: user_id, category_id (1=Distributor, 2=Customer)
 * - order_items: order_id, product_id, quantity (no price)
 * - products: id, sku, name, price
 */
class EloquentOrderRepository implements OrderRepositoryInterface
{
    private const DISTRIBUTOR_CATEGORY_ID = 1;
    private const CUSTOMER_CATEGORY_ID = 2;

    /**
     * Get commission report data with optional filters.
     *
     * This query:
     * 1. Joins orders with users (purchasers)
     * 2. Gets the referrer of the purchaser
     * 3. Counts how many distributors the referrer had at the time of order
     * 4. Calculates commission only if purchaser is Customer AND referrer is Distributor
     */
    public function getCommissionReport(array $filters = []): LengthAwarePaginator
    {
        $perPage = $filters['per_page'] ?? 15;

        $query = DB::table('orders')
            ->select([
                'orders.invoice_number as invoice',
                'orders.order_date',
                'purchaser.id as purchaser_id',
                DB::raw("CONCAT(purchaser.first_name, ' ', purchaser.last_name) as purchaser_name"),
                'purchaser_category.category_id as purchaser_category_id',
                'referrer.id as distributor_id',
                DB::raw("CONCAT(referrer.first_name, ' ', referrer.last_name) as distributor_name"),
                'referrer_category.category_id as referrer_category_id',
                DB::raw("
                    COALESCE(
                        (
                            SELECT COUNT(*)
                            FROM users AS referred
                            INNER JOIN user_category AS rc ON rc.user_id = referred.id
                            WHERE referred.referred_by = referrer.id
                            AND rc.category_id = " . self::DISTRIBUTOR_CATEGORY_ID . "
                            AND referred.enrolled_date <= orders.order_date
                        ),
                        0
                    ) as referred_distributors
                "),
                DB::raw("
                    COALESCE(
                        (
                            SELECT SUM(products.price * order_items.quantity)
                            FROM order_items
                            INNER JOIN products ON products.id = order_items.product_id
                            WHERE order_items.order_id = orders.id
                        ),
                        0
                    ) as order_total
                "),
            ])
            ->join('users as purchaser', 'orders.purchaser_id', '=', 'purchaser.id')
            ->leftJoin('user_category as purchaser_category', 'purchaser.id', '=', 'purchaser_category.user_id')
            ->leftJoin('users as referrer', 'purchaser.referred_by', '=', 'referrer.id')
            ->leftJoin('user_category as referrer_category', function ($join) {
                $join->on('referrer.id', '=', 'referrer_category.user_id')
                    ->where('referrer_category.category_id', '=', self::DISTRIBUTOR_CATEGORY_ID);
            })
            ->orderBy('orders.order_date', 'desc')
            ->orderBy('orders.invoice_number', 'asc');

        // Apply filters
        if (!empty($filters['distributor'])) {
            $distributorSearch = $filters['distributor'];
            $query->where(function ($q) use ($distributorSearch) {
                $q->where('referrer.id', '=', $distributorSearch)
                    ->orWhere('referrer.first_name', 'LIKE', "%{$distributorSearch}%")
                    ->orWhere('referrer.last_name', 'LIKE', "%{$distributorSearch}%");
            });
        }

        if (!empty($filters['date_from'])) {
            $query->where('orders.order_date', '>=', $filters['date_from']);
        }

        if (!empty($filters['date_to'])) {
            $query->where('orders.order_date', '<=', $filters['date_to']);
        }

        if (!empty($filters['invoice'])) {
            $query->where('orders.invoice_number', 'LIKE', "%{$filters['invoice']}%");
        }

        return $query->paginate($perPage);
    }

    /**
     * Get order items by invoice number.
     */
    public function getOrderItems(string $invoice): Collection
    {
        return DB::table('order_items')
            ->select([
                'products.sku',
                'products.name as product_name',
                'products.price',
                'order_items.quantity',
            ])
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->where('orders.invoice_number', '=', $invoice)
            ->get();
    }

    /**
     * Get order by invoice number.
     */
    public function findByInvoice(string $invoice): ?array
    {
        $order = DB::table('orders')
            ->select([
                'orders.id',
                'orders.invoice_number as invoice',
                'orders.order_date',
                'orders.purchaser_id as user_id',
            ])
            ->where('orders.invoice_number', '=', $invoice)
            ->first();

        return $order ? (array) $order : null;
    }
}
