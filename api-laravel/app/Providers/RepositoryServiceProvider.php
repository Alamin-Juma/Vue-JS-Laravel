<?php

declare(strict_types=1);

namespace App\Providers;

use App\Repositories\Contracts\DistributorRepositoryInterface;
use App\Repositories\Contracts\OrderRepositoryInterface;
use App\Repositories\Eloquent\EloquentDistributorRepository;
use App\Repositories\Eloquent\EloquentOrderRepository;
use App\Services\Contracts\CommissionReportServiceInterface;
use App\Services\Contracts\TopDistributorsServiceInterface;
use App\Services\Implementations\CommissionReportService;
use App\Services\Implementations\TopDistributorsService;
use Illuminate\Support\ServiceProvider;

/**
 * Service provider for binding repository and service interfaces to implementations.
 */
class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * All of the container bindings that should be registered.
     *
     * @var array<string, string>
     */
    public array $bindings = [
        // Repositories
        OrderRepositoryInterface::class => EloquentOrderRepository::class,
        DistributorRepositoryInterface::class => EloquentDistributorRepository::class,

        // Services
        CommissionReportServiceInterface::class => CommissionReportService::class,
        TopDistributorsServiceInterface::class => TopDistributorsService::class,
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        foreach ($this->bindings as $abstract => $concrete) {
            $this->app->bind($abstract, $concrete);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
