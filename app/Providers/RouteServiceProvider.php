<?php

namespace App\Providers;

use App\Http\Controllers\ApiController;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public function map()
    {
        Route::prefix('/api')->group(
            static function () {
                /** @see \App\Http\Controllers\ApiController::cinemas() */
                Route::get('cinemas', ApiController::class . '@cinemas');
                Route::get('cinema/all', ApiController::class . '@cinemas');

                /** @see \App\Http\Controllers\ApiController::cinema() */
                Route::get('cinema/{id}', ApiController::class . '@cinema');
            }
        );

        Route::get('/', static function() {return '<p>See <a href="/api/cinemas">/api/cinemas</a> as an exemple</p>';});
    }
}
