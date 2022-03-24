<?php

namespace App\Http\Middleware;

use App\Exceptions\CommandValidationException;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Validator;
use RuntimeException;

class DispatchCommand
{

    /**
     * @param Request $request
     * @param Closure $next
     * @param string $commandName
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $commandName): mixed
    {
        // Verify the command class exist
        if (!class_exists($commandName)) {
            throw new RuntimeException(sprintf('The command %s does not exist!', $commandName));
        }

        // Verify the methode fromPayload
        if (!method_exists($commandName, 'fromPayload')) {
            throw new RuntimeException(sprintf('The method fromPayload does not exist in command %s!', $commandName));
        }

        // Verify the methode validation
        if (!method_exists($commandName, 'validation')) {
            throw new RuntimeException(sprintf('The method "validation" does not exist in command %s!', $commandName));
        }

        //Validate command
        $validator = Validator::make(
            $request->json()->all(),
            $commandName::validation()
        );

        if ($validator->fails()) {
            throw CommandValidationException::invalidCommand($commandName, $validator->errors()->toArray());
        }

        // Dispatch command
        Bus::dispatch(
            $commandName::fromPayload(
                $request->json()->all()
            )
        );

        return $next($request);
    }
}
