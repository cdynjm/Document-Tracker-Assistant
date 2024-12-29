<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

//IMPLMENTATIONS:
use App\Repositories\Implementation\AdminRepository;
use App\Repositories\Implementation\OfficeRepository;
use App\Repositories\Implementation\UserRepository;

//INTERFACES:
use App\Repositories\Interfaces\AdminInterface;
use App\Repositories\Interfaces\OfficeInterface;
use App\Repositories\Interfaces\UserInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AdminInterface::class, AdminRepository::class);
        $this->app->bind(OfficeInterface::class, OfficeRepository::class);
        $this->app->bind(UserInterface::class, UserRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
