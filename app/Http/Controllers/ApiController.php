<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Auditorium;
use App\Models\Cinema;
use App\Models\Movie;
use App\Models\Reservation;
use App\Models\Show;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection as C;

/**
 * Class ApiController
 * @package App\Http\Controllers
 * Serves the path /api/*
 * @see \App\Providers\RouteServiceProvider::map()
 */
class ApiController extends Controller
{
    //<editor-fold desc="Public Entities">
    /**
     * @return array keys: auditoriums, cinemas, movies, shows,
     */
    public function all(): array
    {
        return [
            'auditoriums' => $this->auditoriums(),
            'cinemas' => $this->cinemas(),
            'movies' => $this->movies(),
            'shows' => $this->shows(),
        ];
    }

    /**
     * @param int $id
     * @return null|Cinema
     */
    public function cinema(int $id): ?Cinema
    {
        /** @var Cinema|null $cinema */
        $cinema = Cinema::query()->find($id);
        return $cinema;
    }

    /**
     * @return C|Cinema[]
     */
    public function cinemas(): C
    {
        return Cinema::all();
    }

    /**
     * @param int $id
     * @return null|Auditorium
     */
    public function auditorium(int $id): ?Auditorium
    {
        /** @var Auditorium|null $auditorium */
        $auditorium = Auditorium::query()->find($id);
        return $auditorium;
    }

    /**
     * @return C|Auditorium[]
     */
    public function auditoriums(): C
    {
        return Auditorium::all();
    }

    /**
     * @param int $id
     * @return null|Movie
     */
    public function movie(int $id): ?Movie
    {
        /** @var Movie|null $movie */
        $movie = Movie::query()->find($id);
        return $movie;
    }

    /**
     * @return C|Movie[]
     */
    public function movies(): C
    {
        return Movie::all();
    }

    /**
     * @param int $id
     * @return null|Show
     */
    public function show(int $id): ?Show
    {
        /** @var Show|null $show */
        $show = Show::query()->find($id);
        return $show;
    }

    /**
     * @return C|Show[]
     */
    public function shows(): C
    {
        return Show::all();
    }
    //</editor-fold>

    //<editor-fold desc="Actions">
    /**
     * Login, and get a token as prof of authentication
     * @param Request $request
     * @return string
     */
    public function login(Request $request): string
    {
        $email = (string) ($request->email ?? '');
        $password = (string) ($request->password ?? '');
        if (empty($email)) {
            throw new \RuntimeException('field email is required');
        }
        if (empty($password)) {
            throw new \RuntimeException('field password is required');
        }
        $users = User::query()->where('email', '=', $email)->get();
        $userCount = $users->count();
        if($userCount > 1) {
            throw new \RuntimeException('field email is not unique');
        }
        if($userCount < 1) {
            throw new \RuntimeException('user not found');
        }

        // FIXME: check password

        /** @var User $user */
        $user = $users[0];

        // FIXME: use a secure hash/token
        return $user->id . ':' . md5($user->email);
    }

    /**
     * @param Request $request
     * @return string
     */
    public function register(Request $request): string
    {
        $email = (string) ($request->email ?? '');
        $password = (string) ($request->password ?? '');
        if (empty($email)) {
            throw new \RuntimeException('field email is required');
        }
        if (empty($password)) {
            throw new \RuntimeException('field password is required');
        }
        $userCount = User::query()->where('email', '=', $email)->get()->count();
        if($userCount > 0) {
            throw new \RuntimeException('email already in use');
        }

        $user = User::register($email);

        // FIXME: use a secure hash/token
        return $user->id . ':' . md5($user->email);
    }

    /**
     * Book a reservation of a show
     * @param Request $request
     * @return Reservation
     * @throws \RuntimeException
     */
    public function book(Request $request): Reservation
    {
        $token = (string) ($request->token ?? '');
        $showId = (int) ($request->show_id ?? 0);
        $seats = (int) ($request->seats ?? 0);

        if (empty($token)) {
            throw new \RuntimeException('field token is required');
        }

        // FIXME: use a secure hash/token
        [$userId, $emailHash] = explode(':', $token, 2) + ['',''];
        /** @var User|null $user */
        $user = User::query()->find($userId);
        /** @noinspection HashTimingAttacksInspection */
        if(!$user || !$user->email || $emailHash !== md5($user->email)) {
            throw new \RuntimeException('invalid token');
        }

        /** @var Show|null $show */
        $show = Show::query()->find($showId);
        if(!$show) {
            throw new \RuntimeException('invalid show');
        }

        if($show->start_at->timestamp < time()) {
            throw new \RuntimeException('show already started');
        }

        return Reservation::book($show, $user, $seats);
    }
    //</editor-fold>
}
