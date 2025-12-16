<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Contract for Distributor Repository operations.
 */
interface DistributorRepositoryInterface
{
    /**
     * Get top distributors by total sales.
     *
     * @param int $limit Maximum number of distributors to return
     * @param int $perPage Number of records per page
     */
    public function getTopDistributors(int $limit = 200, int $perPage = 20): LengthAwarePaginator;

    /**
     * Get count of distributors referred by a user up to a specific date.
     */
    public function getDistributorCountByDate(int $referrerId, string $date): int;

    /**
     * Find distributor by ID.
     */
    public function findById(int $id): ?array;
}
