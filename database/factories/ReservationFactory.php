<?php

namespace Database\Factories;

use App\Models\Room;
use App\Models\Guest;
use App\Models\Promotion;
use App\Models\Reservation;
use Illuminate\Database\Eloquent\Factories\Factory;


class ReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'room_id' => Room::factory(),
            'guest_id' => Guest::factory(),
            'promotion_id' => Promotion::factory(),
            'status' => fake()->randomElement(Reservation::ALL_STATUSES),
            'start_date' => fake()->dateTime,
            'end_date' => fake()->dateTime,
            'price' => fake()->numberBetween(100000, 10000000),
            'tax' => fake()->numberBetween(0,10)
        ];
    }
}
