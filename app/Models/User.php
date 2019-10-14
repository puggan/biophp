<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection as C;

/**
 * Class User
 * @package App\Models
 * @property int id
 * @property string email
 * @property C|Authentication[] authentications
 * @property C|Reservation[] reservations
 */
class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = ['email'];

    /**
     * @return HasMany
     */
    public function authentications(): HasMany
    {
        return $this->hasMany(Authentication::class);
    }

    /**
     * @return HasMany
     */
    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }

    /**
     * Register a new user
     * @param string $email
     * @return static
     */
    public static function register(string $email): self
    {
        $user = new User();
        $user->email = $email;
        $user->save();
        return $user;
    }
}
