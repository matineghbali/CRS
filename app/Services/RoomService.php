<?php

namespace App\Services;

use App\Models\Room;
use App\Services\Contracts\BaseService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Database\Eloquent\Builder;

/**
 * Class TaskService
 *
 * @package App\Services
 */
class RoomService extends BaseService
{
    /**
     * @param array $payload
     *
     * @return Collection
     */
    public function availabilities(array $payload): Collection
    {
        return Room::query()
            ->with('availabilities')
            ->whereHas('availabilities', function (Builder $q) {
                return $q->where('is_available', true);
            })
            ->where('capacity', '>=', $payload['guest_count'])
            ->when($payload['start_date'] && $payload['end_date'], function (Builder $q) use ($payload) {
                return $q->whereHas('availabilities', function (Builder $q) use ($payload) {
                    return $q->whereBetween('date', [$payload['start_date'], $payload['end_date']]);
                });
            })
            ->when($payload['min_price'] && $payload['max_price'], function (Builder $q) use ($payload) {
                return $q->whereBetween('price', [$payload['min_price'], $payload['max_price']]);
            })
            ->get();
    }
}
