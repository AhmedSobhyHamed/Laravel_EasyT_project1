<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\blog>
 */
class BlogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "title"=> fake()->name(),
            "content"=> fake()->paragraph(10),
            "visabilty"=> random_int(0,4),
            "auther"=> random_int(1,20)
        ];
    }
}
