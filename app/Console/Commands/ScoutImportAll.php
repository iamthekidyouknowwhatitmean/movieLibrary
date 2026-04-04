<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ScoutImportAll extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scout:import-all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->call('scout:import', ['model' => \App\Models\Film::class]);
        $this->call('scout:import', ['model' => \App\Models\User::class]);
        $this->call('scout:import', ['model' => \App\Models\Review::class]);

        $this->info('All models imported!');
    }
}
