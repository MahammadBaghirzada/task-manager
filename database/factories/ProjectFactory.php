<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    public function definition(): array
    {
        return [
            'creator_id' => User::query()->inRandomOrder()->first()->id ?? User::factory()->create()->id,
            'title' => fake()->sentence(),
        ];
    }
}
