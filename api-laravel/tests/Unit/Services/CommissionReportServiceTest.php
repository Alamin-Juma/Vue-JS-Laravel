<?php

declare(strict_types=1);

use App\Services\Implementations\CommissionReportService;
use App\Repositories\Contracts\OrderRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Enums\UserType;

describe('CommissionReportService', function () {

    describe('calculateCommissionPercentage', function () {
        
        beforeEach(function () {
            $this->mockRepository = Mockery::mock(OrderRepositoryInterface::class);
            $this->service = new CommissionReportService($this->mockRepository);
        });

        it('calculates 5% for 0-4 referred distributors', function () {
            expect($this->service->calculateCommissionPercentage(0))->toBe(5);
            expect($this->service->calculateCommissionPercentage(4))->toBe(5);
        });

        it('calculates 10% for 5-10 referred distributors', function () {
            expect($this->service->calculateCommissionPercentage(5))->toBe(10);
            expect($this->service->calculateCommissionPercentage(8))->toBe(10);
            expect($this->service->calculateCommissionPercentage(10))->toBe(10);
        });

        it('calculates 15% for 11-20 referred distributors', function () {
            expect($this->service->calculateCommissionPercentage(11))->toBe(15);
            expect($this->service->calculateCommissionPercentage(20))->toBe(15);
        });

        it('calculates 20% for 21-29 referred distributors', function () {
            expect($this->service->calculateCommissionPercentage(21))->toBe(20);
            expect($this->service->calculateCommissionPercentage(29))->toBe(20);
        });

        it('calculates 30% for 30+ referred distributors', function () {
            expect($this->service->calculateCommissionPercentage(30))->toBe(30);
            expect($this->service->calculateCommissionPercentage(100))->toBe(30);
        });
    });

    describe('calculateCommission', function () {
        
        beforeEach(function () {
            $this->mockRepository = Mockery::mock(OrderRepositoryInterface::class);
            $this->service = new CommissionReportService($this->mockRepository);
        });

        it('calculates commission correctly when eligible', function () {
            $commission = $this->service->calculateCommission(100.00, 10, true);
            expect($commission)->toBe(10.00);

            $commission = $this->service->calculateCommission(372.00, 10, true);
            expect($commission)->toBe(37.20);
        });

        it('returns 0 when not eligible', function () {
            $commission = $this->service->calculateCommission(100.00, 10, false);
            expect($commission)->toBe(0.0);
        });

        it('returns 0 when percentage is 0', function () {
            $commission = $this->service->calculateCommission(100.00, 0, true);
            expect($commission)->toBe(0.0);
        });

        it('rounds to 2 decimal places', function () {
            $commission = $this->service->calculateCommission(33.33, 10, true);
            expect($commission)->toBe(3.33);
        });
    });

    describe('getReport', function () {
        
        beforeEach(function () {
            $this->mockRepository = Mockery::mock(OrderRepositoryInterface::class);
            $this->service = new CommissionReportService($this->mockRepository);
        });

        it('returns formatted report data', function () {
            $mockData = collect([
                (object) [
                    'invoice' => 'ABC4170',
                    'purchaser_name' => 'Test Customer',
                    'purchaser_id' => 1,
                    'purchaser_category_id' => 2,  // Customer
                    'distributor_name' => 'Test Distributor',
                    'distributor_id' => 2,
                    'referrer_category_id' => 1,  // Distributor
                    'referred_distributors' => 8,
                    'order_date' => '2020-04-11',
                    'order_total' => 60.00,
                ],
            ]);

            $paginator = new LengthAwarePaginator(
                $mockData,
                1,
                15,
                1
            );

            $this->mockRepository
                ->shouldReceive('getCommissionReport')
                ->once()
                ->andReturn($paginator);

            $result = $this->service->getReport([]);

            expect($result)->toHaveKey('data');
            expect($result)->toHaveKey('pagination');
            expect($result['data'])->toHaveCount(1);
            expect($result['data'][0]['invoice'])->toBe('ABC4170');
            expect($result['data'][0]['commission'])->toBe('6.00');
        });

        it('sets commission to 0 when purchaser is not a customer', function () {
            $mockData = collect([
                (object) [
                    'invoice' => 'ABC3010',
                    'purchaser_name' => 'Test Distributor Purchaser',
                    'purchaser_id' => 1,
                    'purchaser_category_id' => 1,  // Distributor
                    'distributor_name' => 'Test Distributor',
                    'distributor_id' => 2,
                    'referrer_category_id' => 1,  // Distributor
                    'referred_distributors' => 8,
                    'order_date' => '2020-04-11',
                    'order_total' => 100.00,
                ],
            ]);

            $paginator = new LengthAwarePaginator(
                $mockData,
                1,
                15,
                1
            );

            $this->mockRepository
                ->shouldReceive('getCommissionReport')
                ->once()
                ->andReturn($paginator);

            $result = $this->service->getReport([]);

            expect($result['data'][0]['commission'])->toBe('0.00');
            expect($result['data'][0]['percentage'])->toBe('0%');
        });

        it('sets commission to 0 when purchaser has no distributor referrer', function () {
            $mockData = collect([
                (object) [
                    'invoice' => 'ABC19323',
                    'purchaser_name' => 'Test Customer',
                    'purchaser_id' => 1,
                    'purchaser_category_id' => 2,  // Customer
                    'distributor_name' => null,
                    'distributor_id' => null,
                    'referrer_category_id' => null,  // No distributor referrer
                    'referred_distributors' => 0,
                    'order_date' => '2020-04-11',
                    'order_total' => 100.00,
                ],
            ]);

            $paginator = new LengthAwarePaginator(
                $mockData,
                1,
                15,
                1
            );

            $this->mockRepository
                ->shouldReceive('getCommissionReport')
                ->once()
                ->andReturn($paginator);

            $result = $this->service->getReport([]);

            expect($result['data'][0]['commission'])->toBe('0.00');
        });
    });

    afterEach(function () {
        Mockery::close();
    });
});
