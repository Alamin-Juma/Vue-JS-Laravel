<?php

declare(strict_types=1);

namespace App\DTOs;

/**
 * Data Transfer Object for Order Items.
 */
readonly class OrderItemDTO
{
    public function __construct(
        public string $sku,
        public string $productName,
        public float $price,
        public int $quantity,
        public float $total,
    ) {}

    /**
     * Create from array (database result).
     */
    public static function fromArray(array $data): self
    {
        $price = (float) $data['price'];
        $quantity = (int) $data['quantity'];
        
        return new self(
            sku: $data['sku'],
            productName: $data['product_name'],
            price: $price,
            quantity: $quantity,
            total: $price * $quantity,
        );
    }

    /**
     * Convert to array for API response.
     */
    public function toArray(): array
    {
        return [
            'sku' => $this->sku,
            'product_name' => $this->productName,
            'price' => number_format($this->price, 2),
            'quantity' => $this->quantity,
            'total' => number_format($this->total, 2),
        ];
    }
}
