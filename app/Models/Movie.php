<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Class Movie
 * @package App\Models
 * @property int id
 * @property string title
 * @property string category
 * @property int length
 * @property int age_limit
 * @property string description
 * @property string language
 * @property Carbon premiere
 */
class Movie extends Model
{
    protected $fillable = ['title', 'category', 'length', 'age_limit', 'description', 'language', 'premiere'];
    protected $casts = ['premiere' => 'datetime'];
}
