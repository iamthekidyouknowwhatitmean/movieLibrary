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
        Schema::create('film_companie', function (Blueprint $table) {
            $table->id();
            $table->foreignId('film_id')->constrained('films', 'tmdb_id')->onDelete('cascade');
            $table->foreignId('companie_id')->constrained('companies','id')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('film_companie');
    }
};
