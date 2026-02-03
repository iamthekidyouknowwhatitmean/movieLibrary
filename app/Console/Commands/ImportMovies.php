<?php

namespace App\Console\Commands;

use App\Models\Films;
use App\Models\Genre;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class ImportMovies extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-movies {pages=5}';

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

        $pages = (int)$this->argument('pages');
        $count = 0;

        for ($page = 1; $page <= $pages; $page++) {
            $response = Http::withOptions([
                'proxy' => 'socks5h://host.docker.internal:12334'
            ])->get("{$baseUrl}/movie/popular", [
                'api_key' => $apiKey,
                'language' => $language,
                'page' => $page,
            ]);

            if ($response->failed()) {
                $this->error("Ошибка при запросе страницы $page");
                continue;
            }

            $films = $response->json()['results'] ?? [];

            foreach ($films as $film) {
                $filmModel = Films::updateOrCreate(
                    ['tmdb_id' => $film['id']],
                    [
                        'title'        => $film['title'],
                        'release_date' => $film['release_date'],
                        'poster_path'       => $film['poster_path'],
                        'backdrop_path' => $film['backdrop_path'],
                        'overview'  => $film['overview'],
                    ]

                );
                $genreIds = Genre::whereIn('tmdb_id', $film['genre_ids'])->pluck('id');
                $filmModel->genres()->sync($genreIds);
                $count++;
            }
        }
        $this->info("Импорт завершён. Сохранено фильмов: {$count}");
        return 0;
    }
}
