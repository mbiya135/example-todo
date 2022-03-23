<?php

namespace App\Providers;

use App\Todo\Domain\Repository\TodoRepository;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        Broadcast::routes();

        require base_path('routes/channels.php');
    }
}
