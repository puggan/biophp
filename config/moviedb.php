<?php
declare(strict_types=1);

return [
    'base_url' => 'https://api.themoviedb.org/3/',
    'imdb_url' => 'find/%IMDBID%?external_source=imdb_id&api_key=%APIKEY%',
    'api_key' => env('MOVIEDB_APIKEY', ''),
];

