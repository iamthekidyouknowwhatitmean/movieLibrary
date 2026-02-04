<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ImportMoviesFromTmdb extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tmdb:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import movies from TMDB to database';

    private $apiKey;
    private $baseUrl;
    private $proxy;

    public function __construct()
    {
        parent::__construct();
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

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $continue = true;
        while($continue)
        {
            $category = $this->choice(
                'Выберите категорию фильмов для импорта:',
                ['top_rated', 'popular', 'upcoming', 'now_playing'],
                0
            );

            $pages = (int)$this->ask('Сколько страниц импортировать? (20 фильмов на страницу)', '1');

            for($p = 1;$p <= $pages;$p++)
            {
                $response = $this->client()->get(
                "{$this->baseUrl}/movie/{$category}",
                [
                    'api_key'  => $this->apiKey,
                    'language' => 'ru-RU',
                    'page'     => $p,
                ]);

                $currentFilms = $response->json()['results'];
                $batch=[];
                $threshold = 20;

                foreach($currentFilms as $film)
                {
                    $batch[] = [
                        'tmdb_id' => $film['id'],
                        'category' => $category,
                        'title' => $film['title'],
                        'release_date' => $film['release_date'] ?? null,
                        'poster_path' => $film['poster_path'] ?? null,
                        'backdrop_path' => $film['backdrop_path'] ?? null,
                        'overview' => $film['overview'] ?? null,
                        'adult' => $film['adult'] ?? null,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ];

                    if(count($batch) >= $threshold)
                    {
                        DB::table('films')->upsert($batch,['tmdb_id'],['title','release_date','poster_path','backdrop_path','overview','adult','updated_at']);
                        $batch = [];
                    }
                }
            }

            $this->info('Фильмы успешно импортированы.');

            $answer = $this->ask('Вы хотитет продолжить? (yes/no)', 'yes');
            if (strtolower($answer) !== 'yes') {
                $continue = false;
            }
        }

        $this->info('Импорт завершен.');
    }
}
