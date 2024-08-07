<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'content' => $this->faker->sentence,
            'user_id' => User::query()->inRandomOrder()->first()->id,
            'commentable_id' => random_int(1, 50),
            'commentable_type' => $this->faker->randomElement(['App\Models\Project', 'App\Models\Task']),
        ];
    }
}
