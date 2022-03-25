<?php

declare(strict_types=1);

namespace App\Exceptions;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class CommandValidationException extends \InvalidArgumentException
{

    /**
     * @var array
     */
    private array $errors;

    /**
     * @param string $commandName
     * @param array $errors
     * @return static
     */
    public static function invalidCommand(string $commandName, array $errors): self
    {
        $exception = new self(
            sprintf(
                'The request for command %s is not valid"',
                $commandName
            )
        );
        $exception->errors = $errors;
        return $exception;
    }

    /**
     * @param array $errors
     * @return static
     */
    public static function invalidRequestData(array $errors): self
    {
        $exception = new self('Invalid request data!');
        $exception->errors = $errors;
        return $exception;
    }

    /**
     * @return array
     */
    public function errors(): array
    {
        return $this->errors;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function render(Request $request): JsonResponse
    {
        return response()->json(
            [
                'message' => $this->getMessage(),
                'errors' => $this->errors,
            ],
            400
        );
    }
}
