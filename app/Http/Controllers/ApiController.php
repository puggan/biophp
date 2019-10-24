<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Auditorium;
use App\Models\Cinema;
use App\Models\Movie;
use App\Models\Reservation;
use App\Models\Show;
use App\Models\User;
use App\Services\MovieDB;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection as C;
use Symfony\Component\HttpKernel\Exception\HttpException;

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
    public static function all(): array
    {
        return [
            'auditoriums' => self::auditoriums(),
            'cinemas' => self::cinemas(),
            'movies' => self::movies(),
            'shows' => self::shows(),
        ];
    }

    /**
     * @param int $id
     * @return Cinema
     * @throws HttpException
     */
    public static function cinema(int $id): Cinema
    {
        /** @var Cinema|null $cinema */
        $cinema = Cinema::query()->find($id);
        if (!$cinema) {
            throw new HttpException(404, 'cinema not found');
        }
        return $cinema;
    }

    /**
     * @return C|Cinema[]
     */
    public static function cinemas(): C
    {
        return Cinema::all();
    }

    /**
     * @param int $id
     * @return Auditorium
     * @throws HttpException
     */
    public static function auditorium(int $id): Auditorium
    {
        /** @var Auditorium|null $auditorium */
        $auditorium = Auditorium::query()->find($id);
        if (!$auditorium) {
            throw new HttpException(404, 'auditorium not found');
        }
        return $auditorium;
    }

    /**
     * @return C|Auditorium[]
     */
    public static function auditoriums(): C
    {
        return Auditorium::all();
    }

    /**
     * @param int $id
     * @return Movie
     * @throws HttpException
     */
    public static function movie(int $id): Movie
    {
        /** @var Movie|null $movie */
        $movie = Movie::query()->find($id);
        if (!$movie) {
            throw new HttpException(404, 'movie not found');
        }
        return $movie;
    }

    /**
     * @return C|Movie[]
     */
    public static function movies(): C
    {
        return Movie::all();
    }

    /**
     * @param int $id
     * @return C|Show[]
     * @throws HttpException
     */
    public static function movieShows(int $id): C
    {
        /** @var Movie|null $movie */
        $movie = Movie::query()->find($id);
        if (!$movie) {
            throw new HttpException(404, 'movie not found');
        }

        return $movie->shows;
    }

    /**
     * @param int $id
     * @return Show
     * @throws HttpException
     */
    public static function show(int $id): Show
    {
        /** @var Show|null $show */
        $show = Show::query()->find($id);
        if (!$show) {
            throw new HttpException(404, 'show not found');
        }
        return $show;
    }

    /**
     * @return C|Show[]
     */
    public static function shows(): C
    {
        return Show::all();
    }
    //</editor-fold>

    //<editor-fold desc="Actions">
    /**
     * @param Request $request
     * @return \stdClass|\PHPDoc\UserWithToken
     * @throws HttpException
     */
    public static function register(Request $request): \stdClass
    {
        $email = (string) ($request->email ?? '');
        $password = (string) ($request->password ?? '');
        if (empty($email)) {
            throw new HttpException(400, 'field email is required');
        }
        if (empty($password)) {
            throw new HttpException(400, 'field password is required');
        }
        $userCount = User::query()->where('email', '=', $email)->get()->count();
        if ($userCount > 0) {
            throw new HttpException(409, 'email already in use');
        }

        $user = User::register($email);

        // FIXME: use a secure hash/token
        $token = $user->id . ':' . md5($user->email);
        return (object) ['id' => $user->id, 'token' => $token, 'email' => $user->email];
    }

    /**
     * Login, and get a token as prof of authentication
     * @param Request $request
     * @return \stdClass|\PHPDoc\UserWithToken
     * @throws HttpException
     */
    public static function login(Request $request): \stdClass
    {
        $email = (string) ($request->email ?? '');
        $password = (string) ($request->password ?? '');
        if (empty($email)) {
            throw new HttpException(401, 'field email is required');
        }
        if (empty($password)) {
            throw new HttpException(401, 'field password is required');
        }
        $users = User::query()->where('email', '=', $email)->get();
        $userCount = $users->count();
        if ($userCount > 1) {
            throw new HttpException(401, 'field email is not unique');
        }
        if ($userCount < 1) {
            throw new HttpException(401, 'user not found');
        }

        // FIXME: check password

        /** @var User $user */
        $user = $users[0];

        // FIXME: use a secure hash/token
        $token = $user->id . ':' . md5($user->email);
        return (object) ['id' => $user->id, 'token' => $token, 'email' => $user->email];
    }

    /**
     * @param Request $request
     * @return array
     * @throws HttpException
     */
    public static function logout(Request $request): array
    {
        $user = User::verifyRequest($request);

        return ['ok' => true, 'id' => $user->id];
    }

    /**
     * @param MovieDB $movieDB
     * @param string $id
     * @return Movie|null
     * @throws \RuntimeException
     */
    public static function import(MovieDB $movieDB, string $id)
    {
        /** @var Movie|null $movie */
        $movie = Movie::query()->where('imdb_tag', '=', $id)->first();
        if (!$movie) {
            $movie = new Movie();
            $movie->imdb_tag = $id;
        }

        $externalMovie = $movieDB->imdb($id);

        $movie->title = $externalMovie->title;
        //$movie->category = $externalMovie->category;
        //$movie->length = $externalMovie->lenght;
        $movie->age_limit = $externalMovie->adult ? 15 : 3;
        $movie->description = $externalMovie->overview;
        $movie->language = $externalMovie->original_language;
        $movie->image_url = "https://image.tmdb.org/t/p/w185_and_h278_bestv2/{$externalMovie->poster_path}";
        try {
            $movie->premiere = new Carbon($externalMovie->release_date);
        } catch (\Exception $ignore) {
        }
        $movie->save();
        return $movie;
    }

    /**
     * Book a reservation of a show
     * @param Request $request
     * @return Reservation
     * @throws HttpException
     */
    public static function book(Request $request): Reservation
    {
        $showId = (int) ($request->show_id ?? 0);
        $seats = (int) ($request->seats ?? 0);

        $user = User::verifyRequest($request);

        if ($seats < 1) {
            throw new HttpException(400, 'invalid seats, required at least one');
        }

        /** @var Show|null $show */
        $show = Show::query()->find($showId);
        if (!$show) {
            throw new HttpException(404, 'invalid show');
        }

        if ($show->start_at->timestamp < time()) {
            throw new HttpException(410, 'show already started');
        }

        try {
            return Reservation::book($show, $user, $seats);
        } catch (\RuntimeException $exception) {
            throw new HttpException(400, $exception->getMessage(), $exception, [], $exception->getCode());
        }
    }
    //</editor-fold>

    //<editor-fold desc="Private Entites">
    /**
     * @param Request $request
     * @param int $id
     * @return Reservation
     * @throws HttpException
     */
    public static function reservation(Request $request, int $id): Reservation
    {
        $user = User::verifyRequest($request);

        /** @var Reservation|null $reservation */
        $reservation = Reservation::query()->with('show.movie')->find($id);

        if (!$reservation || $reservation->user_id !== $user->id) {
            throw new HttpException(404, 'invalid reservation');
        }

        return $reservation;
    }

    /**
     * @param Request $request
     * @return C|Reservation[]
     * @throws HttpException
     */
    public static function reservations(Request $request): C
    {
        $user = User::verifyRequest($request);

        $query = Reservation::query();
        $query->where('user_id', '=', $user->id);

        /** @var C|Reservation[] $reservations */
        $reservations = $query->with('show.movie')->get();

        return $reservations;
    }
    //</editor-fold>
}
