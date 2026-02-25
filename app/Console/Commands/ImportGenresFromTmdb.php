<?php

namespace App\Console\Commands;

use App\Models\Genre;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class ImportGenresFromTmdb extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tmdb:ig';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import genres from tmdb';

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
        $genres = $this->client()
        ->get(
            "{$this->baseUrl}/genre/movie/list",
            [
                'api_key'  => $this->apiKey,
                'language' => 'ru-RU',
            ])
        ->json()['genres'];

        foreach($genres as $genre)
        {
            Genre::create([
                'id' => $genre['id'],
                'name' => $genre['name']
            ]);
        }

        $this->info('Импорт жанров завершен.');
    }
}
