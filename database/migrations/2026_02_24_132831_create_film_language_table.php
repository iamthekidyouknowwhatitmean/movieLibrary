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
        Schema::create('film_language', function (Blueprint $table) {
            $table->char('language_iso',length:3);
            $table->foreignId('film_id')->constrained('films', 'id')->onDelete('cascade');

            $table->foreign('language_iso')
                ->references('iso_639_1')
                ->on('languages')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('film_language');
    }
};
