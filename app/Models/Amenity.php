<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Amenity extends Model
{
    use HasFactory;

    const ACTIVE_STATUS = 'active';
    const INACTIVE_STATUS = 'inactive';
    const ALL_STATUSES = [
        self::ACTIVE_STATUS,
        self::INACTIVE_STATUS
    ];

    /**
     * @var string[]
     */
    protected $fillable = [
        'status',
        'title'
    ];

    /**
     * @return MorphToMany
     */
    public function rooms()
    {
        return $this->morphedByMany(Room::class, 'amenable');
    }

    /**
     * @return MorphToMany
     */
    public function guests()
    {
        return $this->morphedByMany(Guest::class, 'amenable');
    }
}
