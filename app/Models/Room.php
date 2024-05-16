<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Room extends Model
{
    use HasFactory;

    const SINGLE_TYPE = 'single_bed';
    const DOUBLE_TYPE = 'double_bed';
    const TRIPLE_TYPE = 'triple_bed';
    const ALL_TYPES = [
        self::SINGLE_TYPE,
        self::DOUBLE_TYPE,
        self::TRIPLE_TYPE
    ];

    protected $fillable = [
        'type',
        'title',
        'price',
        'capacity'
    ];

    /**
     * @return HasMany
     */
    public function availabilities()
    {
        return $this->hasMany(RoomAvailability::class);
    }

    /**
     * @return MorphToMany
     */
    public function amenities()
    {
        return $this->morphToMany(Amenity::class, 'amenable');
    }

    /**
     * @return MorphMany
     */
    public function promotions()
    {
        return $this->morphMany(Promotion::class, 'promotional');
    }

    /**
     * @return HasMany
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
