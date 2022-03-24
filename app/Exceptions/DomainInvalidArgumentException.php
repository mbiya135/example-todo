<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Models\Todo;
use App\Todo\Domain\TodoStatus;
use Carbon\CarbonImmutable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use InvalidArgumentException;
use Ramsey\Uuid\Uuid;

class DomainInvalidArgumentException extends InvalidArgumentException
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function render(Request $request): JsonResponse
    {
        return response()->json(
            [
                'message' => $this->getMessage(),
            ],
            400
        );
    }
}
