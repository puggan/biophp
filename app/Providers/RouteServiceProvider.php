<?php
/** @noinspection UnusedFunctionResultInspection */
declare(strict_types=1);

namespace App\Providers;

use App\Http\Controllers\ApiController;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

/**
 * Class RouteServiceProvider
 * @package App\Providers
 * Configure all routes
 */
class RouteServiceProvider extends ServiceProvider
{
    /**
     * Configure all routes
     * @see ApiController
     */
    public function map(): void
    {
        Route::prefix('api')->middleware('json')->group(
            static function () {
                //<editor-fold desc="Public Entities">
                /** @see ApiController::cinemas() */
                Route::get('cinemas', ApiController::class . '@cinemas');
                Route::get('cinema/all', ApiController::class . '@cinemas');

                /** @see ApiController::cinema() */
                Route::get('cinema/{id}', ApiController::class . '@cinema');

                /** @see ApiController::auditoriums() */
                Route::get('auditoriums', ApiController::class . '@auditoriums');
                Route::get('auditorium/all', ApiController::class . '@auditoriums');

                /** @see ApiController::auditorium() */
                Route::get('auditorium/{id}', ApiController::class . '@auditorium');

                /** @see ApiController::movies() */
                Route::get('movies', ApiController::class . '@movies');
                Route::get('movie/all', ApiController::class . '@movies');

                /** @see ApiController::movie() */
                Route::get('movie/{id}', ApiController::class . '@movie');

                /** @see ApiController::shows() */
                Route::get('shows', ApiController::class . '@shows');
                Route::get('show/all', ApiController::class . '@shows');

                /** @see ApiController::show() */
                Route::get('show/{id}', ApiController::class . '@show');

                /** @see ApiController::all() */
                Route::get('all', ApiController::class . '@all');
                //</editor-fold>

                //<editor-fold desc="Actions">
                /** @see ApiController::login() */
                Route::post('login', ApiController::class . '@login');
                Route::get('login', static function() {return response(['ok' => false, 'allowed method' => 'post', 'required fields' => ['email', 'password']], 405);} );

                /** @see ApiController::register() */
                Route::post('register', ApiController::class . '@register');
                Route::get('register', static function() {return response(['ok' => false, 'allowed method' => 'post', 'required fields' => ['email', 'password']], 405);} );

                /** @see ApiController::book() */
                Route::post('book', ApiController::class . '@book');
                Route::get('book', static function() {return response(['ok' => false, 'allowed method' => 'post', 'required fields' => ['token','show_id','seats']], 405);} );
                //</editor-fold>

                /** Fix Origin tests */
                Route::options('api/{action}/{id}', static function($action, $id) {return ['ok' => true];});
            }
        );

        Route::get(
            '/',
            static function () {
                /** @noinspection HtmlUnknownTarget */
                return '<p>See <a href="/api/cinemas">/api/cinemas</a> as an example</p>';
            }
        );
    }
}
