<?php

namespace App\Providers;

use App\Todo\Domain\Repository\TodoRepository;
use App\User\Domain\Repository\UserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(TodoRepository::class, \App\Todo\Infrastructure\Repository\TodoRepository::class);
        $this->app->bind(UserRepository::class, \App\User\Infrastructure\Repository\UserRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    }
}
