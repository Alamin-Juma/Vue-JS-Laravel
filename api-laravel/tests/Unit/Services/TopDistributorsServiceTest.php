<?php

declare(strict_types=1);

use App\Services\Implementations\TopDistributorsService;
use App\Repositories\Contracts\DistributorRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

describe('TopDistributorsService', function () {

    describe('getTopDistributors', function () {
        
        beforeEach(function () {
            $this->mockRepository = Mockery::mock(DistributorRepositoryInterface::class);
            $this->service = new TopDistributorsService($this->mockRepository);
        });

        it('returns formatted top distributors data', function () {
            $mockData = collect([
                (object) [
                    'rank' => 1,
                    'distributor_id' => 5,
                    'distributor_name' => 'Demario Purdy',
                    'total_sales' => 22026.75,
                ],
                (object) [
                    'rank' => 2,
                    'distributor_id' => 10,
                    'distributor_name' => 'Floy Miller',
                    'total_sales' => 9645.00,
                ],
            ]);

            $paginator = new LengthAwarePaginator(
                $mockData,
                2,
                20,
                1
            );

            $this->mockRepository
                ->shouldReceive('getTopDistributors')
                ->with(200, 20)
                ->once()
                ->andReturn($paginator);

            $result = $this->service->getTopDistributors(200, 20);

            expect($result)->toHaveKey('data');
            expect($result)->toHaveKey('pagination');
            expect($result['data'])->toHaveCount(2);
            
            expect($result['data'][0]['rank'])->toBe(1);
            expect($result['data'][0]['distributor_name'])->toBe('Demario Purdy');
            expect($result['data'][0]['total_sales'])->toBe('22,026.75');
            expect($result['data'][0]['total_sales_raw'])->toBe(22026.75);
        });

        it('handles distributors with same sales having same rank', function () {
            $mockData = collect([
                (object) [
                    'rank' => 197,
                    'distributor_id' => 15,
                    'distributor_name' => 'Chaim Kuhn',
                    'total_sales' => 360.00,
                ],
                (object) [
                    'rank' => 197,
                    'distributor_id' => 20,
                    'distributor_name' => 'Eliane Bogisich',
                    'total_sales' => 360.00,
                ],
            ]);

            $paginator = new LengthAwarePaginator(
                $mockData,
                2,
                20,
                1
            );

            $this->mockRepository
                ->shouldReceive('getTopDistributors')
                ->with(200, 20)
                ->once()
                ->andReturn($paginator);

            $result = $this->service->getTopDistributors(200, 20);

            // Both should have the same rank of 197
            expect($result['data'][0]['rank'])->toBe(197);
            expect($result['data'][1]['rank'])->toBe(197);
            expect($result['data'][0]['total_sales_raw'])->toBe($result['data'][1]['total_sales_raw']);
        });

        it('returns pagination metadata', function () {
            $mockData = collect([]);
            
            $paginator = new LengthAwarePaginator(
                $mockData,
                100,
                20,
                1
            );

            $this->mockRepository
                ->shouldReceive('getTopDistributors')
                ->once()
                ->andReturn($paginator);

            $result = $this->service->getTopDistributors();

            expect($result['pagination'])->toHaveKey('current_page');
            expect($result['pagination'])->toHaveKey('per_page');
            expect($result['pagination'])->toHaveKey('total');
            expect($result['pagination'])->toHaveKey('last_page');
        });
    });

    afterEach(function () {
        Mockery::close();
    });
});
