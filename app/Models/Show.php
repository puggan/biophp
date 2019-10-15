<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection as C;

/**
 * Class Show
 * @package App\Models
 * @property int id
 * @property Carbon start_at
 * @property string spoken_language
 * @property string subtitle_language
 * @property int seat_price
 * @property int auditorium_id
 * @property Auditorium auditorium
 * @property int movie_id
 * @property Movie movie
 * @property C|Reservation[] reservations
 */
class Show extends Model
{
    protected $fillable = ['start_at', 'spoken_language', 'subtitle_language', 'seat_price'];
    protected $casts = ['start_at' => 'datetime'];
    public $timestamps = false;

    /**
     * @return BelongsTo
     */
    public function auditorium(): BelongsTo
    {
        return $this->belongsTo(Auditorium::class);
    }

    /**
     * @return BelongsTo
     */
    public function movie(): BelongsTo
    {
        return $this->belongsTo(Movie::class);
    }

    /**
     * @return HasMany
     */
    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }

    /**
     * Number of seats booked
     * @return int
     */
    public function seatsTaken(): int
    {
        /// TODO: replace with sum-query
        $seats = 0;
        foreach($this->reservations as $reservation) {
            $seats += $reservation->seat_count;
        }
        return $seats;
    }

    /**
     * Number of seats left
     * @return int
     */
    public function seatsLeft(): int
    {
        return $this->auditorium->seats_total - $this->seatsTaken();
    }
}
