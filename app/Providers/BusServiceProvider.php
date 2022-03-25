<?php

namespace App\Providers;

use App\Todo\Application\AddComment;
use App\Todo\Application\AddCommentHandler;
use App\Todo\Application\AddDeadline;
use App\Todo\Application\AddDeadlineHandler;
use App\Todo\Application\AddTodo;
use App\Todo\Application\AddTodoHandler;
use App\Todo\Application\UpdateTodo;
use App\Todo\Application\UpdateTodoHandler;
use App\User\Application\AddUser;
use App\User\Application\AddUserHandler;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\ServiceProvider;

class BusServiceProvider extends ServiceProvider
{

    public function boot()
    {
        Bus::map(
            [
                AddTodo::class => AddTodoHandler::class,
                UpdateTodo::class => UpdateTodoHandler::class,
                AddComment::class => AddCommentHandler::class,
                AddDeadline::class => AddDeadlineHandler::class,
                // Use domain
                AddUser::class => AddUserHandler::class,
            ]
        );
    }
}
