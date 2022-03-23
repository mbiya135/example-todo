<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;
use RuntimeException;

class DispatchCommand
{

    /**
     * @param Request $request
     * @param Closure $next
     * @param string $commandName
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $commandName)
    {
        if (!class_exists($commandName)) {
            throw new RuntimeException(sprintf('The command %s does not exist', $commandName));
        }

        //Validate command
        $validator = Validator::make(
            $request->json()->all(),
            $commandName::validation()
        );
        if ($validator->fails()) {
            throw new InvalidArgumentException(implode($validator->errors()->toArray()));
        }

        Bus::dispatch(
            $commandName::fromPayload(
                $request->json()->all()
            )
        );

        return $next($request);
    }
}
