<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    public function definition(): array
    {
        return [

            'user_id' => 1,
            'date' => fake()->dateTimeBetween('-1year', 'now'),
            'amount' => fake()->randomFloat(2, 10, 5000),
            'category' => fake()->randomElement(['Groceries', 'Utilities', 'Health', 'Transportation', 'Entertainment']),
        ];
    }
}
