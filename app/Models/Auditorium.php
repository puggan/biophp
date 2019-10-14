<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Auditorium
 * @package App\Models
 * @property int id
 * @property string name
 * @property int seats_total
 * @property Cinema cinema
 */
class Auditorium extends Model
{
    protected $fillable = ['name', 'seats_total'];

    // override default: auditoria
    protected $table = 'auditoriums';
}
