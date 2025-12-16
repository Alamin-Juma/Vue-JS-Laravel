<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\Enums\UserType;
use App\Repositories\Contracts\DistributorRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

/**
 * Eloquent implementation of DistributorRepository.
 * 
 * Actual schema:
 * - user_category table (category_id: 1=Distributor, 2=Customer)
 * - orders.purchaser_id (not user_id)
 * - products table has price, not order_items
 */
class EloquentDistributorRepository implements DistributorRepositoryInterface
{
    private const DISTRIBUTOR_CATEGORY_ID = 1;

    /**
     * Get top distributors by total sales.
     * 
     * Total sales = sum of all orders from users (customers AND distributors) 
     * that were referred by this distributor.
     * 
     * Distributors with the same sales amount get the same rank.
     */
    public function getTopDistributors(int $limit = 200, int $perPage = 20): LengthAwarePaginator
    {
        // Build the query for distributors with their total sales
        $salesQuery = DB::table('users as distributor')
            ->select([
                'distributor.id as distributor_id',
                DB::raw("CONCAT(distributor.first_name, ' ', distributor.last_name) as distributor_name"),
                DB::raw("
                    COALESCE(
                        (
                            SELECT SUM(products.price * oi.quantity)
                            FROM users AS referred
                            INNER JOIN orders AS o ON o.purchaser_id = referred.id
                            INNER JOIN order_items AS oi ON oi.order_id = o.id
                            INNER JOIN products ON products.id = oi.product_id
                            WHERE referred.referred_by = distributor.id
                        ),
                        0
                    ) as total_sales
                "),
            ])
            ->join('user_category as dist_category', function ($join) {
                $join->on('distributor.id', '=', 'dist_category.user_id')
                    ->where('dist_category.category_id', '=', self::DISTRIBUTOR_CATEGORY_ID);
            })
            ->havingRaw('total_sales > 0')
            ->orderByDesc('total_sales')
            ->orderBy('distributor.id')
            ->limit($limit);

        // Get all distributors with sales to calculate proper ranks
        $allDistributors = $salesQuery->get();

        // Calculate ranks (same sales = same rank)
        $ranks = [];
        $currentRank = 0;
        $previousSales = null;
        $sameRankCount = 0;

        foreach ($allDistributors as $index => $distributor) {
            if ($previousSales !== $distributor->total_sales) {
                $currentRank += 1 + $sameRankCount;
                $sameRankCount = 0;
            } else {
                $sameRankCount++;
            }
            $ranks[$distributor->distributor_id] = $currentRank;
            $previousSales = $distributor->total_sales;
        }

        // Now create paginated query with ranks
        $rankedQuery = DB::table('users as distributor')
            ->select([
                'distributor.id as distributor_id',
                DB::raw("CONCAT(distributor.first_name, ' ', distributor.last_name) as distributor_name"),
                DB::raw("
                    COALESCE(
                        (
                            SELECT SUM(products.price * oi.quantity)
                            FROM users AS referred
                            INNER JOIN orders AS o ON o.purchaser_id = referred.id
                            INNER JOIN order_items AS oi ON oi.order_id = o.id
                            INNER JOIN products ON products.id = oi.product_id
                            WHERE referred.referred_by = distributor.id
                        ),
                        0
                    ) as total_sales
                "),
            ])
            ->join('user_category as dist_category', function ($join) {
                $join->on('distributor.id', '=', 'dist_category.user_id')
                    ->where('dist_category.category_id', '=', self::DISTRIBUTOR_CATEGORY_ID);
            })
            ->havingRaw('total_sales > 0')
            ->orderByDesc('total_sales')
            ->orderBy('distributor.id')
            ->limit($limit);

        // Create a custom paginator that includes ranks
        $paginated = $rankedQuery->paginate($perPage);

        // Add ranks to each item
        $paginated->getCollection()->transform(function ($item) use ($ranks) {
            $item->rank = $ranks[$item->distributor_id] ?? 0;
            return $item;
        });

        return $paginated;
    }

    /**
     * Get count of distributors referred by a user up to a specific date.
     */
    public function getDistributorCountByDate(int $referrerId, string $date): int
    {
        return DB::table('users')
            ->where('referred_by', '=', $referrerId)
            ->where('user_type', '=', UserType::DISTRIBUTOR->value)
            ->where('joined_date', '<=', $date)
            ->count();
    }

    /**
     * Find distributor by ID.
     */
    public function findById(int $id): ?array
    {
        $user = DB::table('users')
            ->select([
                'id',
                'first_name',
                'last_name',
                'user_type',
                'referred_by',
                'joined_date',
            ])
            ->where('id', '=', $id)
            ->where('user_type', '=', UserType::DISTRIBUTOR->value)
            ->first();

        return $user ? (array) $user : null;
    }
}
