<?php

namespace App\Providers;

use App\Interface\ClientInterface;
use App\Interface\EmployeeInterface;
use App\Interface\ProjectInterface;
use App\Interface\RepositoryInterface;
use App\Interface\TaskInterface;
use App\Repositories\BaseRepositories;
use Illuminate\Support\ServiceProvider;
use App\Repositories\ClientRepositories;
use App\Repositories\EmployeeRepositories;
use App\Repositories\ProjectRepositories;
use App\Repositories\TaskRepositories;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
       $this->app->bind(RepositoryInterface::class, BaseRepositories::class);
    }
}
