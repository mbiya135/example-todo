<?php

namespace App\Http\Controllers\Todo;

use App\Http\Controllers\Controller;
use App\Http\Resources\TodoResource;
use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TodoListController extends Controller
{

    /**
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function list(Request $request)
    {
        return TodoResource::collection(Todo::where('user_id', auth()->user()->uuid)->paginate());
    }
}
