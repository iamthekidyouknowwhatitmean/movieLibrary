<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    protected $guarded = [];

    public function films()
    {
        return $this->belongsToMany(Films::class, 'film_genre');
    }
}
