<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class TmdbService
{
    protected $apiKey;
    protected $baseUrl;
    protected $language;

    public function __construct()
    {
        $this->apiKey = config('tmdb.api_key');
        $this->baseUrl = config('tmdb.base_url');
        $this->language = config('tmdb.language');
    }

    public function getPopularMovies($page = 2)
    {
        $response = Http::withOptions([
            'proxy' => 'http://127.0.0.1:12334'
        ])->get("{$this->baseUrl}/movie/popular", [
            'api_key' => $this->apiKey,
            'language' => $this->language,
            'page' => 1
        ]);

        return $response->json();
    }
    public function getAllGenres()
    {
        $response = Http::withOptions([
            'proxy' => 'http://127.0.0.1:12334'
        ])->get("{$this->baseUrl}/genre/movie/list", [
            'api_key' => $this->apiKey,
            'language' => $this->language,
        ]);

        return $response->json()['genres'];
    }
}
