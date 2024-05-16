<?php

namespace Tests\Unit\Services;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\Room;
use App\Services\RoomService;
use App\Models\RoomAvailability;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RoomServiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_can_get_available_rooms(): void
    {
        //Find rooms available for specific dates and guest count, considering room types and pricing.
        $room = Room::factory()
            ->create();
        $roomAvailability = RoomAvailability::factory()
            ->create([
                'room_id' => $room->id,
                'is_available' => true
            ]);
        $payload = [
            'guest_count' => $room->capacity,
            'start_date' => (string) Carbon::create($roomAvailability->date)->subDay(),
            'end_date' => (string) Carbon::create($roomAvailability->date)->addDay(),
            'min_price' => $room->price - fake()->randomNumber(),
            'max_price' => $room->price + fake()->randomNumber(),
        ];

        $response = app()->make(RoomService::class)->availabilities($payload);

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertEquals($response->first()->id, $room->id);
    }
}
