<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * Class Show
 * @package App\Models
 * @property int id
 * @property Carbon start_at
 * @property string spoken_language
 * @property string subtitle_language
 * @property int seat_price
 * @property Auditorium auditorium
 * @property Movie movie
 */
class Show extends Model
{
    protected $fillable = ['start_at', 'spoken_language', 'subtitle_language', 'seat_price'];
    protected $casts = ['start_at' => 'datetime'];

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
}
