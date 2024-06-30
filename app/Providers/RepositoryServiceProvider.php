<?php

namespace App\Providers;

use App\Repositories\Contracts\EmployeeRepositoryInterface;
use App\Repositories\Contracts\EmployeeTransactionRepositoryInterface;
use App\Repositories\EmployeeRepository;
use App\Repositories\EmployeeTransactionRepository;
use App\Services\EmployeeTransactionService;
use App\Services\Contracts\EmployeeServiceInterface;
use App\Services\Contracts\EmployeeTransactionServiceInterface;
use App\Services\EmployeeService;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(EmployeeRepositoryInterface::class, EmployeeRepository::class);
        $this->app->singleton(EmployeeTransactionRepositoryInterface::class, EmployeeTransactionRepository::class);
        $this->app->singleton(EmployeeServiceInterface::class, EmployeeService::class);
        $this->app->singleton(EmployeeTransactionServiceInterface::class, EmployeeTransactionService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
