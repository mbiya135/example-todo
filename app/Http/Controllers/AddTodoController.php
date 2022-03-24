<?php

namespace App\Http\Controllers;

use App\Todo\Application\AddTodo;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AddTodoController extends Controller
{

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index(Request $request)
    {
        $this->dispatch(
            AddTodo::fromPayload(
                [
                    'todo_id' => Str::uuid()->toString(),
                    'todo_description' => 'test',
                    'user_id' => Str::uuid()->toString(),
                ]
            )
        );

        return response('');
    }
}
