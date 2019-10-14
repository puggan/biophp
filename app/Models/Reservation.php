<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * Class Reservation
 * @package App\Models
 * @property int id
 * @property int seat_count
 * @property int first_seat_number
 * @property Carbon reserved_at
 * @property int user_id
 * @property User user
 * @property int show_id
 * @property Show show
 * @property Payment payment
 */
class Reservation extends Model
{
    protected $fillable = ['seat_count', 'first_seat_number', 'reserved_at'];
    protected $casts = ['reserved_at' => 'datetime'];
    const CREATED_AT = 'reserved_at';
    const UPDATED_AT = null;

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

    /**
     * @return HasOne
     */
    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }

    /**
     * Book a reservation on a show, for a user
     * @param Show $show
     * @param User $user
     * @param int $seatCount
     * @return static
     * @throws \RuntimeException
     */
    public static function book(Show $show, User $user, int $seatCount): self
    {
        $seatsTaken = $show->seatsTaken();
        $seatsLeft = $show->auditorium->seats_total - $seatsTaken;
        if($seatsLeft < $seatCount) {
            throw new \RuntimeException('seats taken, only ' . $seatsLeft . ' seats left');
        }

        $reservation = new self();
        $reservation->show_id = $show->id;
        $reservation->user_id = $user->id;
        $reservation->seat_count = $seatCount;
        $reservation->first_seat_number = 1 + $seatsTaken;
        $reservation->save();
        return $reservation;
    }
}
