<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RoomAvailability extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'room_id',
        'date',
        'is_available'
    ];

    /**
     * @return BelongsTo
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
