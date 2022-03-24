<?php

use App\Todo\Application\AddComment;
use App\Todo\Application\AddTodo;
use App\Todo\Application\UpdateTodo;
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
    'todo',
    'App\Http\Controllers\CommandController@index'
)->middleware(
    'command.dispatch:' . AddTodo::class,
);

Route::put(
    'todo',
    'App\Http\Controllers\CommandController@index'
)->middleware(
    'command.dispatch:' . UpdateTodo::class,
);

Route::put(
    'todo/comment',
    'App\Http\Controllers\CommandController@index'
)->middleware(
    'command.dispatch:' . AddComment::class,
);


Route::get('todo', 'App\Http\Controllers\CommandController@index');
//->parameter('commande_name', 'test');
