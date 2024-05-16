<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Promotion extends Model
{
    use HasFactory;

    const PERCENT_TYPE = 'percent';
    const PRICE_TYPE = 'price';
    const ALL_TYPES = [
        self::PERCENT_TYPE,
        self::PRICE_TYPE
    ];

    /**
     * @var string[]
     */
    protected $fillable = [
        'type',
        'discount_value',
        'discount_code',
        'start_date',
        'end_date',
        'promotional_id',
        'promotional_type'
    ];

    /**
     * @return MorphTo
     */
    public function promotional()
    {
        return $this->morphTo();
    }

    /**
     * @return HasMany
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
