<?php

namespace App\Models;

use App\Http\Filters\QueryFilter;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * @property int $id
 * @property int $tmdb_id
 * @property string $category
 * @property string $title
 * @property string|null $release_date
 * @property string|null $poster_path
 * @property string|null $backdrop_path
 * @property string|null $overview
 * @property int $adult
 * @property float $popularity
 * @property float $vote_average
 * @property float $vote_count
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Genre> $genres
 * @property-read int|null $genres_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $likedByUsers
 * @property-read int|null $liked_by_users_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Rating> $ratings
 * @property-read int|null $ratings_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Review> $reviews
 * @property-read int|null $reviews_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Database\Factories\FilmsFactory factory($count = null, $state = [])
 * @method static Builder<static>|Films filter(\App\Http\Filters\QueryFilter $filters)
 * @method static Builder<static>|Films newModelQuery()
 * @method static Builder<static>|Films newQuery()
 * @method static Builder<static>|Films query()
 * @method static Builder<static>|Films whereAdult($value)
 * @method static Builder<static>|Films whereBackdropPath($value)
 * @method static Builder<static>|Films whereCategory($value)
 * @method static Builder<static>|Films whereCreatedAt($value)
 * @method static Builder<static>|Films whereId($value)
 * @method static Builder<static>|Films whereOverview($value)
 * @method static Builder<static>|Films wherePopularity($value)
 * @method static Builder<static>|Films wherePosterPath($value)
 * @method static Builder<static>|Films whereReleaseDate($value)
 * @method static Builder<static>|Films whereTitle($value)
 * @method static Builder<static>|Films whereTmdbId($value)
 * @method static Builder<static>|Films whereUpdatedAt($value)
 * @method static Builder<static>|Films whereVoteAverage($value)
 * @method static Builder<static>|Films whereVoteCount($value)
 * @mixin \Eloquent
 */
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
    protected $primaryKey = 'tmdb_id';
    public $incrementing = false;
    protected $keyType = 'int';

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

    public function scopeFilter(Builder $builder, QueryFilter $filters)
    {
        return $filters->apply($builder);
    }

    public function countries()
    {
        return $this->belongsToMany(ProductionCountries::class);
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
