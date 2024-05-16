<?php

namespace App\Models;

use App\Services\PromotionService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Contracts\Container\BindingResolutionException;

class Reservation extends Model
{
    use HasFactory;

    const PENDING_STATUS = 'pending';
    const SUCCESS_STATUS = 'success';
    const FAILED_STATUS = 'failed';
    const ALL_STATUSES = [
        self::PENDING_STATUS,
        self::SUCCESS_STATUS,
        self::FAILED_STATUS
    ];

    /**
     * @var string[]
     */
    protected $fillable = [
        'room_id',
        'guest_id',
        'promotion_id',
        'status',
        'room_type',
        'start_date',
        'end_date',
        'price',
        'tax'
    ];

    /**
     * @return BelongsTo
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * @return BelongsTo
     */
    public function guest()
    {
        return $this->belongsTo(Guest::class);
    }

    /**
     * @return BelongsTo
     */
    public function promotion()
    {
        return $this->belongsTo(Promotion::class);
    }

    /**
     * @return HasOne
     */
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    /**
     * @return Attribute
     */
    protected function roomType(): Attribute
    {
        return Attribute::make(
            set: fn(string $value) => $this->room->type
        );
    }

    /**
     * @return Attribute
     */
    protected function totalCost(): Attribute
    {
//        Calculate the total cost of a reservation (including room price, taxes, and any applicable promotions)
        $roomPrice = $this->room->price;
        return Attribute::make(
            get: fn($value) => ($roomPrice + ($roomPrice * $this->tax / 100)) - $this->promotion_discount
        );
    }

    /**
     * @return Attribute
     *
     * @throws BindingResolutionException
     */
    protected function promotionDiscount(): Attribute
    {
        //Apply a promotion to a reservation and update the total cost.
        $promotionDiscount = app()->make(PromotionService::class)->calculate($this);

        return Attribute::make(
            get: fn($value) => $promotionDiscount
        );
    }
}
