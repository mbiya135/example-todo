<?php

namespace Database\Factories;

use App\Todo\Domain\TodoStatus;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class TodoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'uuid' => $this->faker->uuid(),
            'description' => $this->faker->text(),
            'user_id' => $this->faker->uuid(),
            'status' => TodoStatus::OPEN,
            'created_at' => $this->faker->text,
        ];
    }

}
