<?php

namespace App\Models;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Films extends Model
{
    /** @use HasFactory<\Database\Factories\FilmsFactory> */
    use HasFactory;
    use Searchable;
    // protected $fillable = [
    //     'id',
    //     'name'
    // ];
    protected $guarded = [];


    public function toSearchableArray()
    {
        return [
            'id' => (int) $this->id,
            'tmdb_id' => $this->tmdb_id,
            'title' => $this->title,
            'release_date' => (int) $this->release_date,
            'poster_path' => $this->poster_path,
            'backdrop_path' => $this->backdrop_path,
            'overview' => $this->overview,
            'updated_at' => $this->updated_at,

        ];
    }

    public function users() // ????????
    {
        return $this->belongsToMany(User::class, 'user_film');
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'film_genre');
    }

    public function likes() // пока хз зачем
    {
        return $this->hasMany(Like::class, 'likes');
    }


    public function likedByUsers() // Пользователи, которые лайкнули фильм
    {
        return $this->belongsToMany(User::class, 'likes');
    }
}
