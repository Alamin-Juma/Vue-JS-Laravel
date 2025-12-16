<?php

declare(strict_types=1);

namespace App\DTOs;

/**
 * Data Transfer Object for Top Distributors Report entries.
 */
readonly class TopDistributorDTO
{
    public function __construct(
        public int $rank,
        public int $distributorId,
        public string $distributorName,
        public float $totalSales,
    ) {}

    /**
     * Create from array (database result).
     */
    public static function fromArray(array $data): self
    {
        return new self(
            rank: (int) $data['rank'],
            distributorId: (int) $data['distributor_id'],
            distributorName: $data['distributor_name'],
            totalSales: (float) $data['total_sales'],
        );
    }

    /**
     * Convert to array for API response.
     */
    public function toArray(): array
    {
        return [
            'rank' => $this->rank,
            'distributor_id' => $this->distributorId,
            'distributor_name' => $this->distributorName,
            'total_sales' => number_format($this->totalSales, 2),
            'total_sales_raw' => $this->totalSales,
        ];
    }
}
