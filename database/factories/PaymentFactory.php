<?php

namespace Database\Factories;

use App\Models\Payment;
use App\Models\Reservation;
use Illuminate\Database\Eloquent\Factories\Factory;


class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'reservation_id' => Reservation::factory(),
            'method' => fake()->randomElement(Payment::ALL_METHODS),
            'transaction_code' => fake()->uuid(),
            'refund_code' => fake()->uuid,
        ];
    }
}
