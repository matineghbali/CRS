<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class GuestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'first_name' => fake()->firstName,
            'last_name' => fake()->lastName,
            'national_code' => (string) fake()->randomNumber(),
            'phone_number' => fake()->phoneNumber,
            'email' => fake()->email(),
            'birthdate' => fake()->dateTime,
            'loyalty_program' => fake()->text,
        ];
    }
}
