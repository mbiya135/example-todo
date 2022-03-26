<?php

use App\Todo\Application\AddComment;
use App\Todo\Application\AddDeadline;
use App\Todo\Application\AddTodo;
use App\Todo\Application\UpdateTodo;
use App\User\Application\AddUser;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::post(
    '/api/todo',
    'App\Http\Controllers\CommandController@index'
)->middleware(
    ['auth:api', 'command.dispatch:' . AddTodo::class,]
);

Route::put(
    '/api/todo',
    'App\Http\Controllers\CommandController@index'
)->middleware(
    ['auth:api', 'command.dispatch:' . UpdateTodo::class,]
);

Route::post(
    '/api/todo/comment',
    'App\Http\Controllers\CommandController@index'
)->middleware(
    'command.dispatch:' . AddComment::class,
);

Route::post(
    '/api/todo/deadline',
    'App\Http\Controllers\CommandController@index'
)->middleware(
    'command.dispatch:' . AddDeadline::class,
);

Route::post(
    '/api/user',
    'App\Http\Controllers\CommandController@index'
)->middleware(
    'command.dispatch:' . AddUser::class,
);


Route::post('/api/login', 'App\Http\Controllers\Auth\AuthController@login');
Route::get(
    '/api/todos',
    'App\Http\Controllers\Todo\TodoListController@list'
)
    ->middleware('auth:api');
