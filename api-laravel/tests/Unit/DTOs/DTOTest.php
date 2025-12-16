<?php

declare(strict_types=1);

use App\DTOs\CommissionReportDTO;
use App\DTOs\OrderItemDTO;
use App\DTOs\TopDistributorDTO;

describe('CommissionReportDTO', function () {
    
    it('creates from array correctly', function () {
        $data = [
            'invoice' => 'ABC123',
            'purchaser_name' => 'John Doe',
            'purchaser_id' => 1,
            'distributor_name' => 'Jane Smith',
            'distributor_id' => 2,
            'referred_distributors' => 5,
            'order_date' => '2020-01-15',
            'percentage' => 10,
            'order_total' => 100.00,
            'commission' => 10.00,
        ];

        $dto = CommissionReportDTO::fromArray($data);

        expect($dto->invoice)->toBe('ABC123');
        expect($dto->purchaserName)->toBe('John Doe');
        expect($dto->distributorName)->toBe('Jane Smith');
        expect($dto->referredDistributors)->toBe(5);
        expect($dto->percentage)->toBe(10);
        expect($dto->orderTotal)->toBe(100.00);
        expect($dto->commission)->toBe(10.00);
    });

    it('converts to array correctly', function () {
        $dto = new CommissionReportDTO(
            invoice: 'ABC123',
            purchaserName: 'John Doe',
            purchaserId: 1,
            distributorName: 'Jane Smith',
            distributorId: 2,
            referredDistributors: 5,
            orderDate: '2020-01-15',
            percentage: 10,
            orderTotal: 100.00,
            commission: 10.00,
        );

        $array = $dto->toArray();

        expect($array['invoice'])->toBe('ABC123');
        expect($array['purchaser'])->toBe('John Doe');
        expect($array['distributor'])->toBe('Jane Smith');
        expect($array['percentage'])->toBe('10%');
        expect($array['order_total'])->toBe('100.00');
        expect($array['commission'])->toBe('10.00');
    });
});

describe('OrderItemDTO', function () {
    
    it('creates from array and calculates total', function () {
        $data = [
            'sku' => 'SK22',
            'product_name' => 'Product A',
            'price' => 25.00,
            'quantity' => 2,
        ];

        $dto = OrderItemDTO::fromArray($data);

        expect($dto->sku)->toBe('SK22');
        expect($dto->productName)->toBe('Product A');
        expect($dto->price)->toBe(25.00);
        expect($dto->quantity)->toBe(2);
        expect($dto->total)->toBe(50.00);
    });

    it('formats output array correctly', function () {
        $dto = new OrderItemDTO(
            sku: 'SK22',
            productName: 'Product A',
            price: 25.50,
            quantity: 3,
            total: 76.50,
        );

        $array = $dto->toArray();

        expect($array['price'])->toBe('25.50');
        expect($array['total'])->toBe('76.50');
    });
});

describe('TopDistributorDTO', function () {
    
    it('creates from array correctly', function () {
        $data = [
            'rank' => 1,
            'distributor_id' => 5,
            'distributor_name' => 'Top Seller',
            'total_sales' => 22026.75,
        ];

        $dto = TopDistributorDTO::fromArray($data);

        expect($dto->rank)->toBe(1);
        expect($dto->distributorId)->toBe(5);
        expect($dto->distributorName)->toBe('Top Seller');
        expect($dto->totalSales)->toBe(22026.75);
    });

    it('includes both formatted and raw sales in array', function () {
        $dto = new TopDistributorDTO(
            rank: 1,
            distributorId: 5,
            distributorName: 'Top Seller',
            totalSales: 22026.75,
        );

        $array = $dto->toArray();

        expect($array['total_sales'])->toBe('22,026.75');
        expect($array['total_sales_raw'])->toBe(22026.75);
    });
});
