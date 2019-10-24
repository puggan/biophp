<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection as C;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

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
    public $timestamps = false;

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

    /**
     * @param Request $request
     * @return static
     * @throws HttpException
     */
    public static function verifyRequest(Request $request): self
    {
        $token = (string) ($request->token ?? '');

        if (empty($token)) {
            throw new HttpException(401, 'field token is required');
        }

        // FIXME: use a secure hash/token
        [$userId, $emailHash] = explode(':', $token, 2) + ['', ''];

        /** @var self|null $user */
        $user = User::query()->find($userId);

        /** @noinspection HashTimingAttacksInspection */
        if (!$user || !$user->email || $emailHash !== md5($user->email)) {
            throw new HttpException(401, 'invalid token');
        }

        return $user;
    }

    /**
     * @param string $email
     * @return static|null
     * @throws \RuntimeException
     */
    public static function getByEmail(string $email): ?self
    {
        $users = self::query()->where('email', '=', $email)->get();
        $userCount = $users->count();
        if ($userCount > 1) {
            throw new \RuntimeException('Email found on more then one user');
        }
        if ($userCount < 1) {
            return null;
        }
        return $users[0];
    }
}
