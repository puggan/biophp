<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Authentication
 * @package App\Models
 * @property int id
 * @property string servise
 * @property string identyfier
 * @property string secret
 * @property User user
 */
class Authentication extends Model
{
    protected $fillable = ['servise', 'identyfier'];
    protected $hidden = ['secret'];
}
