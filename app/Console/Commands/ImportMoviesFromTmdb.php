<?php

namespace App\Console\Commands;

use App\Models\Films;
use App\Models\Genre;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Pool;

class ImportMoviesFromTmdb extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tmdb:i';

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

    private function flushToDatabase(array $batchOfFilms, array $batchOfGenres) {
        Films::upsert(
            $batchOfFilms,
            ['tmdb_id'],
            ['title','release_date','poster_path','backdrop_path','overview','adult','budget','revenue',
            'runtime','status','tagline','updated_at']
        );
        $fl = DB::table('film_genre')->insertOrIgnore($batchOfGenres);
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

            $batch=[];
            $batchOfGenres = [];
            $threshold = 500;
            for($p = 1;$p <= $pages;$p++)
            {
                $response = $this->client()
                    ->retry(3,200)
                    ->get(
                    "{$this->baseUrl}/movie/{$category}",
                    [
                        'api_key'  => $this->apiKey,
                        'language' => 'ru-RU',
                        'page'     => $p,
                    ])
                    ->json();

                $films = collect($response['results']);

                $currentFilms = Http::pool(fn (Pool $pool) => $films->map(fn($film) =>
                    $pool->withOptions([
                        'proxy' => $this->proxy,
                    ])->get("{$this->baseUrl}/movie/{$film['id']}",[
                        'api_key'  => $this->apiKey,
                        'language' => 'ru-RU',
                    ])
                ));

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
                        'popularity' => $film['popularity'] ?? null,
                        'vote_average' => $film['vote_average'] ?? null,
                        'vote_count' => $film['vote_count'] ?? null,
                        'budget' => $film['budget'],
                        'revenue' => $film['revenue'],
                        'runtime' => $film['runtime'],
                        'status' => $film['status'],
                        'tagline' => $film['tagline'],
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ];

                    foreach($film['genres'] as $genre)
                    {
                        $batchOfGenres[] = [
                            'film_id' => $film['id'],
                            'genre_id' => $genre['id']
                        ];
                    }

                    if(count($batch) >= $threshold)
                    {
                        $this->flushToDatabase($batch,$batchOfGenres);
                        $batch = [];
                        $batchOfGenres = [];
                    }
                }
            }
            if(!empty($batch))
            {
                $this->flushToDatabase($batch,$batchOfGenres);
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
