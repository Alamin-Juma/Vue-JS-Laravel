<?php

declare(strict_types=1);

namespace App\Services\Contracts;

use Illuminate\Support\Collection;

/**
 * Contract for Commission Report Service operations.
 */
interface CommissionReportServiceInterface
{
    /**
     * Get commission report with calculated commissions.
     *
     * @param array{
     *     distributor?: string|null,
     *     date_from?: string|null,
     *     date_to?: string|null,
     *     invoice?: string|null,
     *     per_page?: int
     * } $filters
     */
    public function getReport(array $filters = []): array;

    /**
     * Get order items for a specific invoice.
     */
    public function getOrderItems(string $invoice): Collection;

    /**
     * Calculate commission percentage based on referred distributors count.
     */
    public function calculateCommissionPercentage(int $referredDistributors): int;

    /**
     * Calculate commission amount.
     */
    public function calculateCommission(float $orderTotal, int $percentage, bool $isEligible): float;
}
