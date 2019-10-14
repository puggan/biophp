<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
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
}
