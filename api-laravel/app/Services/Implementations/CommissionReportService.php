<?php

declare(strict_types=1);

namespace App\Services\Implementations;

use App\DTOs\CommissionReportDTO;
use App\DTOs\OrderItemDTO;
use App\Enums\CommissionTier;
use App\Enums\UserType;
use App\Repositories\Contracts\OrderRepositoryInterface;
use App\Services\Contracts\CommissionReportServiceInterface;
use Illuminate\Support\Collection;

/**
 * Service for generating commission reports.
 */
class CommissionReportService implements CommissionReportServiceInterface
{
    public function __construct(
        private readonly OrderRepositoryInterface $orderRepository
    ) {}

    /**
     * Get commission report with calculated commissions.
     */
    public function getReport(array $filters = []): array
    {
        $paginated = $this->orderRepository->getCommissionReport($filters);

        $items = collect($paginated->items())->map(function ($row) {
            $referredDistributors = (int) $row->referred_distributors;
            $orderTotal = (float) $row->order_total;
            
            // Commission is only earned if:
            // 1. Purchaser is a Customer (category_id = 2)
            // 2. Purchaser's referrer is a Distributor (category_id = 1)
            $isCustomer = $row->purchaser_category_id == 2;  // 2 = Customer
            $hasDistributorReferrer = $row->referrer_category_id == 1; // 1 = Distributor
            $isEligible = $isCustomer && $hasDistributorReferrer;
            
            $percentage = $isEligible 
                ? $this->calculateCommissionPercentage($referredDistributors)
                : 0;
            
            $commission = $this->calculateCommission($orderTotal, $percentage, $isEligible);

            return CommissionReportDTO::fromArray([
                'invoice' => $row->invoice,
                'purchaser_name' => $row->purchaser_name,
                'purchaser_id' => $row->purchaser_id,
                'distributor_name' => $isEligible ? $row->distributor_name : null,
                'distributor_id' => $isEligible ? $row->distributor_id : null,
                'referred_distributors' => $isEligible ? $referredDistributors : 0,
                'order_date' => $row->order_date,
                'percentage' => $percentage,
                'order_total' => $orderTotal,
                'commission' => $commission,
            ])->toArray();
        });

        return [
            'data' => $items->toArray(),
            'pagination' => [
                'current_page' => $paginated->currentPage(),
                'per_page' => $paginated->perPage(),
                'total' => $paginated->total(),
                'last_page' => $paginated->lastPage(),
                'from' => $paginated->firstItem(),
                'to' => $paginated->lastItem(),
            ],
        ];
    }

    /**
     * Get order items for a specific invoice.
     */
    public function getOrderItems(string $invoice): Collection
    {
        return $this->orderRepository->getOrderItems($invoice)
            ->map(fn ($item) => OrderItemDTO::fromArray((array) $item)->toArray());
    }

    /**
     * Calculate commission percentage based on referred distributors count.
     */
    public function calculateCommissionPercentage(int $referredDistributors): int
    {
        return CommissionTier::getPercentage($referredDistributors);
    }

    /**
     * Calculate commission amount.
     */
    public function calculateCommission(float $orderTotal, int $percentage, bool $isEligible): float
    {
        if (!$isEligible || $percentage === 0) {
            return 0.0;
        }

        return round($orderTotal * ($percentage / 100), 2);
    }
}
