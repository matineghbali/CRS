<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    const BANK_ONE_METHOD = 'bank_one';
    const BANK_TWO_METHOD = 'bank_two';
    const BANK_THREE_METHOD = 'bank_three';
    const ALL_METHODS = [
        self::BANK_ONE_METHOD,
        self::BANK_TWO_METHOD,
        self::BANK_THREE_METHOD
    ];

    /**
     * @var string[]
     */
    protected $fillable = [
        'reservation_id',
        'method',
        'transaction_code',
        'refund_code'
    ];

    /**
     * @return BelongsTo
     */
    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }
}
