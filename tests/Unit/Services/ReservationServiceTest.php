<?php

namespace Tests\Unit\Services;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\Room;
use App\Models\Guest;
use App\Models\Promotion;
use App\Models\Reservation;
use App\Services\ReservationService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReservationServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_guest_reservations(): void
    {
        //Retrieve guest reservations with associated room details, including pricing and taxes
        $guest = Guest::factory()
            ->create();
        $reservation = Reservation::factory()
            ->create([
                'guest_id' => $guest->id
            ]);

        $response = $this->app->make(ReservationService::class)->guestReservations($guest);

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertEquals($response->first()->id, $reservation->id);
    }

    public function test_can_get_revenues_for_date_range(): void
    {
        //Calculate total revenue for a given date range, segmented by room type
        $room1 = Room::factory()->create([
            'type' => Room::SINGLE_TYPE
        ]);
        $room2 = Room::factory()->create([
            'type' => Room::TRIPLE_TYPE
        ]);
        $room3 = Room::factory()->create([
            'type' => Room::SINGLE_TYPE
        ]);
        $reservation1 = Reservation::factory()
            ->create([
                'status' => Reservation::SUCCESS_STATUS,
                'room_id' => $room1->id,
                'room_type' => $room1->type,
                'start_date' => now()->toDateString(),
                'end_date' => now()->addDays(5)->toDateString(),
            ]);
        $reservation2 = Reservation::factory()
            ->create([
                'status' => Reservation::SUCCESS_STATUS,
                'room_id' => $room2->id,
                'room_type' => $room2->type,
                'start_date' => now()->toDateString(),
                'end_date' => now()->addDays(5)->toDateString(),
            ]);
        $reservation3 = Reservation::factory()
            ->create([
                'status' => Reservation::SUCCESS_STATUS,
                'room_id' => $room3->id,
                'room_type' => $room3->type,
                'start_date' => now()->toDateString(),
                'end_date' => now()->addDays(5)->toDateString(),
            ]);
        $payload = [
            'start_date' => (string)Carbon::create(now()->toDateString())->subDay(),
            'end_date' => (string)Carbon::create(now()->addDays(5)->toDateString())->addDay()
        ];

        $response = $this->app->make(ReservationService::class)->totalRevenue($payload);

        $this->assertInstanceOf(\Illuminate\Support\Collection::class, $response);
        $this->assertEquals($response[Room::SINGLE_TYPE]['total_revenue'],
            ($reservation1->price + ($reservation1->price * $reservation1->tax / 100)) +
            ($reservation3->price + ($reservation3->price * $reservation3->tax / 100))
        );
        $this->assertEquals($response[Room::TRIPLE_TYPE]['total_revenue'],
            ($reservation2->price + ($reservation2->price * $reservation2->tax / 100)));

    }

    public function test_can_exist_reservation()
    {
//        Reservation::query()
//            ->where('guest_id', $payload['guest_id'])
//            ->where('room_type', $payload['roomType'])
//            ->whereBetween('start_date', [$payload['start_date'], $payload['end_date']])
//            ->whereBetween('end_date', [$payload['start_date'], $payload['end_date']])
//            ->exists();
        //Check if a guest has an existing reservation for a specific date and room type
        $room = Room::factory()->create();
        $reservation = Reservation::factory()
            ->create([
                'status' => Reservation::SUCCESS_STATUS,
                'room_id'=>$room->id,
                'room_type'=>$room->type,
            ]);
        $payload = [
            'guest_id' => $reservation->guest_id,
            'room_type' => $reservation->room_type,
            'start_date' => $reservation->start_date,
            'end_date' => $reservation->end_date,
        ];

        $response = $this->app->make(ReservationService::class)->existReservation($payload);

        $this->assertIsBool($response);
        $this->assertEquals(true, $response);
    }

    public function test_can_get_total_cost()
    {
        $promotion = Promotion::factory()
            ->create([
                'type' => Promotion::PERCENT_TYPE,
                'discount_value' => fake()->numberBetween(10, 90)
            ]);
        $reservation = Reservation::factory()
            ->create([
                'promotion_id' => $promotion->id,
            ]);

        $this->assertEquals(($reservation->room->price +
                ($reservation->room->price * $reservation->tax / 100)) - $reservation->promotion_discount
            , $reservation->total_cost);
    }

    public function test_can_get_promotion_discount()
    {
        $promotion = Promotion::factory()
            ->create([
                'type' => Promotion::PERCENT_TYPE,
                'discount_value' => fake()->numberBetween(10, 90)
            ]);
        $reservation = Reservation::factory()
            ->create([
                'promotion_id' => $promotion->id,
            ]);

        $this->assertEquals($reservation->price * $promotion->discount_value / 100 , $reservation->promotion_discount);
    }
}
