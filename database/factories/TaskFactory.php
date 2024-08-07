<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    public function definition(): array
    {
        return [
            'creator_id' => User::query()->inRandomOrder()->first()->id,
            'project_id' => random_int(1, 20),
            'title' => fake()->sentence(),
            'is_done' => fake()->boolean(),
        ];
    }
}
