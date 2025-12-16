<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

/**
 * Contract for Order Repository operations.
 */
interface OrderRepositoryInterface
{
    /**
     * Get commission report data with optional filters.
     *
     * @param array{
     *     distributor?: string|null,
     *     date_from?: string|null,
     *     date_to?: string|null,
     *     invoice?: string|null,
     *     per_page?: int
     * } $filters
     */
    public function getCommissionReport(array $filters = []): LengthAwarePaginator;

    /**
     * Get order items by invoice number.
     */
    public function getOrderItems(string $invoice): Collection;

    /**
     * Get order by invoice number.
     */
    public function findByInvoice(string $invoice): ?array;
}
