<?php

namespace App\Providers;

use App\Todo\Application\AddTodo;
use App\Todo\Application\AddTodoHandler;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\ServiceProvider;

class BusServiceProvider extends ServiceProvider
{

    public function boot()
    {
        Bus::map(
            [
                AddTodo::class => AddTodoHandler::class,
            ]
        );
    }
}
