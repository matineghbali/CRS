<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Model
{
    use HasFactory;

    const RATE_VALUES = [1, 2, 3, 4, 5];

    /**
     * @var string[]
     */
    protected $fillable = [
        'guest_id',
        'rate',
        'comment'
    ];

    /**
     * @return BelongsTo
     */
    public function guest()
    {
        return $this->belongsTo(Guest::class);
    }
}
