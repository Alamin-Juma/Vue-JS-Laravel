<?php

declare(strict_types=1);

namespace App\Services\Contracts;

/**
 * Contract for Top Distributors Service operations.
 */
interface TopDistributorsServiceInterface
{
    /**
     * Get top distributors report with rankings.
     *
     * @param int $limit Maximum number of distributors
     * @param int $perPage Records per page
     */
    public function getTopDistributors(int $limit = 200, int $perPage = 20): array;
}
