<?php

declare(strict_types=1);

namespace App\Services\Implementations;

use App\DTOs\TopDistributorDTO;
use App\Repositories\Contracts\DistributorRepositoryInterface;
use App\Services\Contracts\TopDistributorsServiceInterface;

/**
 * Service for generating top distributors report.
 */
class TopDistributorsService implements TopDistributorsServiceInterface
{
    public function __construct(
        private readonly DistributorRepositoryInterface $distributorRepository
    ) {}

    /**
     * Get top distributors report with rankings.
     */
    public function getTopDistributors(int $limit = 200, int $perPage = 20): array
    {
        $paginated = $this->distributorRepository->getTopDistributors($limit, $perPage);

        $items = collect($paginated->items())->map(function ($row) {
            return TopDistributorDTO::fromArray([
                'rank' => $row->rank,
                'distributor_id' => $row->distributor_id,
                'distributor_name' => $row->distributor_name,
                'total_sales' => $row->total_sales,
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
}
