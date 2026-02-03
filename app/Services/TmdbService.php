<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TmdbService
{
    protected $apiKey;
    protected $baseUrl;
    protected $proxy;

    public function __construct()
    {
        $this->apiKey = config('tmdb.api_key');
        $this->baseUrl = config('tmdb.base_url');
        $this->proxy = config('tmdb.proxy');
    }

    private function client()
    {
        $options = [];

        if ($this->proxy) {
            $options['proxy'] = $this->proxy;
        }

        return Http::withOptions($options);
    }

    public function getMovie($id)
    {
        try {
            $response = $this->client()->get("{$this->baseUrl}/movie/$id", [
                'api_key'  => $this->apiKey,
                'language' => 'en-En',
            ]);

            return $response->json();
        } catch (\Exception $e) {
            Log::error('TMDB API Error: ' . $e->getMessage());
            throw $e;
        }
    }

    // public function getPopularMovies($page = 2)
    // {
    //     $response = Http::withOptions([
    //         'proxy' => 'socks5h://127.0.0.1:12334'
    //     ])->get("{$this->baseUrl}/movie/popular", [
    //         'api_key' => $this->apiKey,
    //         'language' => $this->language,
    //         'page' => 1
    //     ]);

    //     return $response->json();
    // }
    // public function getAllGenres()
    // {
    //     $response = Http::withOptions([
    //         'proxy' => 'socks5h://127.0.0.1:12334'
    //     ])->get("{$this->baseUrl}/genre/movie/list", [
    //         'api_key' => $this->apiKey,
    //         'language' => $this->language,
    //     ]);

    //     return $response->json()['genres'];
    // }
}
