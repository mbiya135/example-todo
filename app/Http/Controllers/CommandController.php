<?php

namespace App\Http\Controllers;

use App\Todo\Application\AddTodo;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class CommandController extends Controller
{

    /**
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        return response()->json(['success']);
    }
}
