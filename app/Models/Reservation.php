<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * Class Reservation
 * @package App\Models
 * @property int id
 * @property int seat_count
 * @property int first_seat_number
 * @property Carbon reserved_at
 * @property User user
 * @property Show show
 */
class Reservation extends Model
{
    protected $fillable = ['seat_count', 'first_seat_number', 'reserved_at'];
    protected $casts = ['reserved_at' => 'datetime'];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function show(): BelongsTo
    {
        return $this->belongsTo(Show::class);
    }
}
