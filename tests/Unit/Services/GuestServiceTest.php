<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Models\Room;
use App\Models\Guest;
use App\Models\Amenity;
use App\Services\GuestService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GuestServiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_can_get_next_month_birthdays(): void
    {
        //Find guests with birthdays within the next month and rooms matching their preferences
        $amenity = Amenity::factory()
            ->create();
        $guest = Guest::factory()
            ->create([
                'birthdate' => now()->subDecades(2)->addDays(10)->toDateString()
            ]);
        $room = Room::factory()
            ->create();
        $guest->amenities()->sync([$amenity->id]);
        $room->amenities()->sync([$amenity->id]);

        $response = $this->app->make(GuestService::class)->nextMonthBirthdays();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertEquals($response->first()->id, $guest->id);
    }
}
