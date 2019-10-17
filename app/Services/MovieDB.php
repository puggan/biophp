<?php

namespace App\Services;

/**
 * Class MovieDB
 * @package App\Services
 */
class MovieDB
{
    /** @var string $apiKey */
    private /* string */
        $apiKey;

    /** @var string $baseUrl */
    private /* string */
        $baseUrl;

    /** @var string $imdbUrl */
    private /* string */
        $imdbUrl;

    public function __construct()
    {
        $this->apiKey = config('moviedb.api_key');
        $this->baseUrl = config('moviedb.base_url');
        $this->imdbUrl = config('moviedb.imdb_url');
    }

    /**
     * @param string $imdbId
     * @return \stdClass|\PHPDoc\MovieDB\Movie
     * @throws \RuntimeException
     */
    public function imdb(string $imdbId) : \stdClass
    {
        $url = strtr(
            $this->imdbUrl,
            [
                '%IMDBID%' => $imdbId,
                '%APIKEY%' => $this->apiKey,
            ]
        );
        /** @var \PHPDoc\MovieDB\FindResult $result */
        $result = json_decode($this->get($url), false, 512, JSON_THROW_ON_ERROR);
        $movie = $result->movie_results[0] ?? null;
        if(!$movie) {
            throw new \RuntimeException('Movie not found');
        }
        return $movie;
    }

    /**
     * @param string $path
     * @return string
     * @throws \RuntimeException
     */
    private function get(string $path): string
    {
        $response = (new \GuzzleHttp\Client())->get($this->baseUrl . $path);
        $statusCode = $response->getStatusCode();
        if($statusCode !== 200) {
            throw new \RuntimeException('HTTP-error, code: ' . $statusCode, $statusCode);
        }
        return (string) $response->getBody();
    }
}
