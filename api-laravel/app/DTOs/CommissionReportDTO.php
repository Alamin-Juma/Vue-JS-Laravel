<?php

declare(strict_types=1);

namespace App\DTOs;

/**
 * Data Transfer Object for Commission Report entries.
 */
readonly class CommissionReportDTO
{
    public function __construct(
        public string $invoice,
        public string $purchaserName,
        public ?int $purchaserId,
        public ?string $distributorName,
        public ?int $distributorId,
        public int $referredDistributors,
        public string $orderDate,
        public int $percentage,
        public float $orderTotal,
        public float $commission,
    ) {}

    /**
     * Create from array (database result).
     */
    public static function fromArray(array $data): self
    {
        return new self(
            invoice: $data['invoice'],
            purchaserName: $data['purchaser_name'],
            purchaserId: $data['purchaser_id'] ?? null,
            distributorName: $data['distributor_name'] ?? null,
            distributorId: $data['distributor_id'] ?? null,
            referredDistributors: (int) ($data['referred_distributors'] ?? 0),
            orderDate: $data['order_date'],
            percentage: (int) ($data['percentage'] ?? 0),
            orderTotal: (float) ($data['order_total'] ?? 0),
            commission: (float) ($data['commission'] ?? 0),
        );
    }

    /**
     * Convert to array for API response.
     */
    public function toArray(): array
    {
        return [
            'invoice' => $this->invoice,
            'purchaser' => $this->purchaserName,
            'purchaser_id' => $this->purchaserId,
            'distributor' => $this->distributorName,
            'distributor_id' => $this->distributorId,
            'referred_distributors' => $this->referredDistributors,
            'order_date' => $this->orderDate,
            'percentage' => $this->percentage . '%',
            'order_total' => number_format($this->orderTotal, 2),
            'commission' => number_format($this->commission, 2),
        ];
    }
}
