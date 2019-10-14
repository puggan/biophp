<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Class User
 * @package App\Models
 * @property int id
 * @property string email
 */
class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = ['email'];
}
