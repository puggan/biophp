<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Class Payment
 * @package App\Models
 * @property int id
 * @property Carbon payed_at
 * @property int amount
 * @property string refernece
 * @property Reservation reservation
 */
class Payment extends Model
{
    protected $fillable = ['payed_at', 'amount', 'refernece'];
    protected $casts = ['payed_at' => 'datetime'];
}
