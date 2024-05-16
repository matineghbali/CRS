<?php

namespace App\Services;

use App\Models\Guest;
use App\Services\Contracts\BaseService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Database\Eloquent\Builder;

/**
 * Class TaskService
 *
 * @package App\Services
 */
class GuestService extends BaseService
{
    /**
     * @return Collection
     */
    public function nextMonthBirthdays(): Collection
    {
        $nextMonth = now()->addMonth()->month;
        $currentMonth = now()->month;
        $currentDay = now()->day;
        return Guest::query()
            ->with('amenities.rooms')
            ->where(function (Builder $q) use ($nextMonth, $currentMonth, $currentDay) {
                return $q->where(function (Builder $q) use ($nextMonth, $currentMonth, $currentDay) {
                    return $q->whereMonth('birthdate', $currentMonth)
                        ->whereDay('birthdate', '>=', $currentDay);
                })->orWhere(function (Builder $q) use ($nextMonth, $currentMonth, $currentDay) {
                    return $q->whereMonth('birthdate', $nextMonth)
                        ->whereDay('birthdate', '<', $currentDay);
                });
            })
            ->get();
    }
}
