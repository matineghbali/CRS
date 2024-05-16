<?php

namespace Database\Factories;

use App\Models\Guest;
use App\Models\Review;
use Illuminate\Database\Eloquent\Factories\Factory;


class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'geust_id' => Guest::factory(),
            'rate' => fake()->randomElement(Review::RATE_VALUES),
            'comment' => fake()->text,
        ];
    }
}
