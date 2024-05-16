<?php
namespace Database\Factories;

use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;


class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'type' => fake()->randomElement(Room::ALL_TYPES),
            'title' => fake()->title,
            'price' => fake()->numberBetween(100000, 10000000),
            'capacity' => fake()->numberBetween(1,3)
        ];
    }
}
