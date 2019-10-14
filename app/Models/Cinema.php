<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Cinema
 * @package App\Models
 * @property int id
 * @property string name
 * @property string location
 */
class Cinema extends Model
{
    protected $fillable = ['name', 'location'];
}
