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
        Schema::create('films', function (Blueprint $table) {
            $table->id();
            $table->enum('category',['popular','top_rated','upcoming','now_playing']);
            $table->string('title');
            $table->date('release_date');
            $table->string('poster_path')->nullable();
            $table->string('backdrop_path')->nullable();
            $table->text('overview');
            $table->boolean('adult')->default(false);
            $table->float('popularity');
            $table->float('vote_average')->nullable();
            $table->integer('vote_count')->nullable();
            $table->integer('budget');
            $table->unsignedBigInteger('revenue');
            $table->integer('runtime');
            $table->string('status');
            $table->string('tagline');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('films');
    }
};
