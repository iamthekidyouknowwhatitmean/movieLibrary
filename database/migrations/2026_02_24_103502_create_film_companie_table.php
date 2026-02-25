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
            $table->foreignId('film_id')->constrained('films', 'id')->onDelete('cascade');
            $table->foreignId('companie_id')->constrained('companies','id')->onDelete('cascade');

            $table->unique(['film_id','companie_id']);
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
