<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Guest extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'national_code',
        'phone_number',
        'email',
        'birthdate',
        'loyalty_program'
    ];

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

    /**
     * @return HasMany
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
