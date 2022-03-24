<?php

namespace App\Providers;

use App\Projectors\TodoProjector;
use App\Todo\Application\AddComment;
use App\Todo\Application\AddCommentHandler;
use App\Todo\Application\AddTodo;
use App\Todo\Application\AddTodoHandler;
use App\Todo\Application\UpdateTodo;
use App\Todo\Application\UpdateTodoHandler;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\ServiceProvider;
use Spatie\EventSourcing\Facades\Projectionist;

class EventSourcingServiceProvider extends ServiceProvider
{

    public function register()
    {
        // you can also add multiple projectors in one go
        Projectionist::addProjectors(
            [
                TodoProjector::class,
            ]
        );
    }
}
