<?php

namespace App\Console\Commands;

use App\Models\Genre;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class ImportGenres extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-genres';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Импорт фильмов из TMDB в базу данных';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $apiKey = config('tmdb.api_key');
        $baseUrl = config('tmdb.base_url');
        $language = config('tmdb.language');

        $response = Http::withOptions([
            'proxy' => 'socks5h://host.docker.internal:12334'
        ])->get("{$baseUrl}/genre/movie/list", [
            'api_key' => $apiKey,
            'language' => $language,
        ]);

        $genres = $response->json()['genres'] ?? [];

        foreach ($genres as $genre) {
            Genre::updateOrCreate(
                [
                    'tmdb_id' => $genre['id'],
                    'name' => $genre['name']
                ]
            );
        }
        $this->info("Импорт жанров завершён");
    }
}
