<?php

namespace App\Services;

use App\Models\Promotion;
use App\Models\Reservation;
use App\Services\Contracts\BaseService;

/**
 * Class TaskService
 *
 * @package App\Services
 */
class PromotionService extends BaseService
{

    public function calculate(Reservation $reservation)
    {
        $promotion = $reservation->promotion;
        return $promotion
            ? $promotion->type === Promotion::PERCENT_TYPE
                ? $reservation->price * $promotion->discount_value / 100
                : ($promotion->discount_value > $reservation->price
                    ? $reservation->price
                    : $promotion->discount_value)
            : 0;
    }

}
