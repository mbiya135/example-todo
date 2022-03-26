<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class TodoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request): array|Arrayable|JsonSerializable
    {
        return parent::toArray(
            [
                'todo_id' => $this->uuid,
                'user_id' => $this->user_id,
                'description' => $this->description,
                'status' => $this->status,
                'created_at' => $this->created_at,
                'deadline' => $this->deadline,
            ]
        );
    }
}
