<?php


namespace Database\Factories;

use App\Models\Room;
use App\Models\Promotion;
use Illuminate\Database\Eloquent\Factories\Factory;


class PromotionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $type = fake()->randomElement(Promotion::ALL_TYPES);
        return [
            'type' => $type,
            'discount_value' => $type === Promotion::PERCENT_TYPE
                ? fake()->numberBetween(10,100)
                : fake()->numberBetween(10000, 1000000),
            'discount_code' => fake()->name,
            'start_date' => fake()->dateTime,
            'end_date' => fake()->dateTime,
            'promotional_id' => Room::factory(),
            'promotional_type' => Room::class
        ];
    }
}
