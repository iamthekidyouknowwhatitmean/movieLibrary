<?php

namespace App\Console\Commands;

use App\Models\Films;
use App\Models\Genre;
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
                $response = $this->client()
                ->get(
                    "{$this->baseUrl}/movie/{$category}",
                    [
                        'api_key'  => $this->apiKey,
                        'language' => 'ru-RU',
                        'page'     => $p,
                    ]);


                $currentFilms = $response->json()['results'];
                $batch=[];
                $batchOfGenres = [];
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
                        'popularity' => $film['popularity'] ?? null,
                        'vote_average' => $film['vote_average'] ?? null,
                        'vote_count' => $film['vote_count'] ?? null,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ];
                    $batchOfGenres[$film['id']] = $film['genre_ids'];

                    if(count($batch) >= $threshold)
                    {
                        DB::table('films')->upsert($batch,['tmdb_id'],['title','release_date','poster_path','backdrop_path','overview','adult','updated_at']);
                        foreach($batchOfGenres as $filmId=>$genreIds){
                            $film = DB::table('films')->where('tmdb_id',$filmId)->value('id');
                            foreach($genreIds as $genreId){
                                $genre = DB::table('genres')->where('tmdb_id',$genreId)->value('id');
                                DB::table('film_genre')->insert([
                                    'films_id' => $film,
                                    'genre_id' => $genre
                                ]);
                            }
                        }
                        $batch = [];
                        $batchOfGenres = [];
                    }
                }

                // проверять, что batch пуст и если это так, догрузить в таблицу оставшиеся данные

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
