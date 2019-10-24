<?php

namespace PHPDoc\MovieDB {
    /**
     * Class UserWithToken
     * @package PHPDoc\MovieDB
     * @property int id
     * @property string token
     * @property string email
     */
    class UserWithToken {

    }
}

namespace PHPDoc {
    /**
     * Class FindResult
     * @package PHPDoc\MovieDB
     *
     * @property Movie[] movie_results
     * @property array person_results
     * @property array tv_results
     * @property array tv_episode_results
     * @property array tv_season_results
     */
    class FindResult
    {}

    /**
     * Class Movie
     * @package PHPDoc\MovieDB
     *
     * @property int id
     * @property bool video
     * @property int vote_count
     * @property float vote_average
     * @property string title
     * @property string release_date
     * @property string original_language
     * @property string original_title
     * @property int[] genre_ids
     * @property string backdrop_path
     * @property bool adult
     * @property string overview
     * @property string poster_path
     * @property float popularity
     */
    class Movie
    {}
}
