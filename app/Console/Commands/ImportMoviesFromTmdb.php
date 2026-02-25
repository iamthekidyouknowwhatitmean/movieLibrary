<?php

namespace App\Console\Commands;

use App\Models\Films;
use App\Models\Genre;
use App\Models\Languages;
use App\Models\ProductionCountries;
use App\Models\ProductionCompanies;
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

    private function flushToDatabase(
        array $batchOfFilms,
        array $batchOfGenres,
        array $batchOfCompanies,
        array $batchOfCompaniesPivot,
        array $batchOfCountries,
        array $batchOfCountriesPivot,
        array $batchOfLanguages,
        array $batchOfLanguagesPivot
    ) {
        Films::upsert(
            $batchOfFilms,
            ['id'],
            ['title','release_date','poster_path','backdrop_path','overview','adult','budget','revenue',
            'runtime','status','tagline','updated_at']
        );
        ProductionCountries::upsert(
            $batchOfCountries,
            ['iso_3166_1'],
            ['name']
        );
        ProductionCompanies::upsert(
            $batchOfCompanies,
            ['id'],
            ['logo_path','name','origin_country']
        );
        Languages::upsert(
            $batchOfLanguages,
            ['iso_639_1'],
            ['english_name','name']
        );

        DB::table('film_genre')->upsert(
            $batchOfGenres,
            ['film_id','genre_id'],
            ['film_id','genre_id']
        );
        DB::table('film_country')->upsert(
            $batchOfCountriesPivot,
            ['country_iso'],
            ['film_id']
        );
        DB::table('film_companie')->upsert(
            $batchOfCompaniesPivot,
            ['film_id','companie_id'],
            ['film_id','companie_id']
        );
        DB::table('film_language')->upsert(
            $batchOfLanguagesPivot,
            ['language_iso'],
            ['film_id']
        );

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
            $batchOfCompanies = [];
            $batchOfCompaniesPivot = [];
            $batchOfCountries = [];
            $batchOfCountriesPivot = [];
            $batchOfLanguages = [];
            $batchOfLanguagesPivot = [];

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
                        'id' => $film['id'],
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

                    foreach($film['production_companies'] as $companie)
                    {
                        $batchOfCompanies[] = $companie;
                        $batchOfCompaniesPivot[] = [
                            'film_id' => $film['id'],
                            'companie_id' => $companie['id']
                        ];
                    }

                    foreach($film['production_countries'] as $country)
                    {
                        $batchOfCountries[] = $country;
                        $batchOfCountriesPivot[] = [
                            'film_id' => $film['id'],
                            'country_iso' => $country['iso_3166_1']
                        ];
                    }

                    foreach($film['spoken_languages'] as $language)
                    {
                        $batchOfLanguages[] = $language;
                        $batchOfLanguagesPivot[] = [
                            'film_id' => $film['id'],
                            'language_iso' => $language['iso_639_1']
                        ];
                    }
                    if(count($batch) >= $threshold)
                    {
                        $this->flushToDatabase(
                            $batch,
                            $batchOfGenres,
                            $batchOfCompanies,
                            $batchOfCompaniesPivot,
                            $batchOfCountries,
                            $batchOfCountriesPivot,
                            $batchOfLanguages,
                            $batchOfLanguagesPivot
                        );
                        $batch = [];
                        $batchOfGenres = [];
                        $batchOfCompanies = [];
                        $batchOfCompaniesPivot = [];
                        $batchOfCountries = [];
                        $batchOfCountriesPivot = [];
                        $batchOfLanguages = [];
                        $batchOfLanguagesPivot = [];
                    }
                }
            }

            if(!empty($batch))
            {
                $this->flushToDatabase(
                    $batch,
                    $batchOfGenres,
                    $batchOfCompanies,
                    $batchOfCompaniesPivot,
                    $batchOfCountries,
                    $batchOfCountriesPivot,
                    $batchOfLanguages,
                    $batchOfLanguagesPivot
                );
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
