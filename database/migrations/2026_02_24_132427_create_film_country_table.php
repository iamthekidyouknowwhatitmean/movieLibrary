<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('film_country', function (Blueprint $table) {
           $table->char('country_iso',length:3);
           $table->foreignId('film_id')->constrained('films', 'tmdb_id')->onDelete('cascade');

            $table->foreign('country_iso')
                ->references('iso_3166_1')
                ->on('production_countries')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('film_country');
    }
};
