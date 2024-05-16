<?php

namespace App\Services;

use App\Models\Guest;
use App\Models\Reservation;
use App\Services\Contracts\BaseService;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class TaskService
 *
 * @package App\Services
 */
class ReservationService extends BaseService
{
    /**
     * @param Guest $guest
     *
     * @return Collection
     */
    public function guestReservations(Guest $guest): Collection
    {
        return Reservation::query()
            ->where('guest_id', $guest->id)
            ->with('room')
            ->get();
    }

    /**
     * @param array $payload
     *
     * @return  \Illuminate\Support\Collection
     */
    public function totalRevenue(array $payload): \Illuminate\Support\Collection
    {
        return Reservation::query()
            ->whereBetween('start_date', [$payload['start_date'], $payload['end_date']])
            ->whereBetween('end_date', [$payload['start_date'], $payload['end_date']])
            ->get()
            ->groupBy('room_type')
            ->map(function ($reservations) {
                return [
                    'total_revenue' => $reservations->sum(function ($reservation) {
                        return $reservation->price + ($reservation->price * $reservation->tax / 100);
                    })
                ];
            });
    }

    /**
     * @param array $payload
     *
     * @return bool
     */
    public function existReservation(array $payload): bool
    {
        return Reservation::query()
            ->where('status', Reservation::SUCCESS_STATUS)
            ->where('guest_id', $payload['guest_id'])
            ->where('room_type', $payload['room_type'])
            ->whereDate('start_date', $payload['start_date'])
            ->whereDate('end_date', $payload['end_date'])
            ->exists();
    }
}
