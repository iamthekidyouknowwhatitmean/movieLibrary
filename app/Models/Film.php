<?php

namespace App\Models;

use App\Http\Filters\QueryFilter;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * @property int $id
 * @property string $category
 * @property string $title
 * @property string $release_date
 * @property string|null $poster_path
 * @property string|null $backdrop_path
 * @property string $overview
 * @property int $adult
 * @property float $popularity
 * @property float|null $vote_average
 * @property int|null $vote_count
 * @property int $budget
 * @property int $revenue
 * @property int $runtime
 * @property string $status
 * @property string $tagline
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProductionCountries> $countries
 * @property-read int|null $countries_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Genre> $genres
 * @property-read int|null $genres_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $likedByUsers
 * @property-read int|null $liked_by_users_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Review> $reviews
 * @property-read int|null $reviews_count
 * @method static \Database\Factories\FilmFactory factory($count = null, $state = [])
 * @method static Builder<static>|Film filter(\App\Http\Filters\QueryFilter $filters)
 * @method static Builder<static>|Film newModelQuery()
 * @method static Builder<static>|Film newQuery()
 * @method static Builder<static>|Film query()
 * @method static Builder<static>|Film search(string $terms)
 * @method static Builder<static>|Film whereAdult($value)
 * @method static Builder<static>|Film whereBackdropPath($value)
 * @method static Builder<static>|Film whereBudget($value)
 * @method static Builder<static>|Film whereCategory($value)
 * @method static Builder<static>|Film whereCreatedAt($value)
 * @method static Builder<static>|Film whereId($value)
 * @method static Builder<static>|Film whereOverview($value)
 * @method static Builder<static>|Film wherePopularity($value)
 * @method static Builder<static>|Film wherePosterPath($value)
 * @method static Builder<static>|Film whereReleaseDate($value)
 * @method static Builder<static>|Film whereRevenue($value)
 * @method static Builder<static>|Film whereRuntime($value)
 * @method static Builder<static>|Film whereStatus($value)
 * @method static Builder<static>|Film whereTagline($value)
 * @method static Builder<static>|Film whereTitle($value)
 * @method static Builder<static>|Film whereUpdatedAt($value)
 * @method static Builder<static>|Film whereVoteAverage($value)
 * @method static Builder<static>|Film whereVoteCount($value)
 * @mixin \Eloquent
 */
class Film extends Model
{
    /** @use HasFactory<\Database\Factories\FilmsFactory> */
    use HasFactory;
    use Searchable;
    // protected $fillable = [
    //     'id',
    //     'name'
    // ];
    protected $guarded = [];
    protected $keyType = 'int';

    public function toSearchableArray()
    {
        return [
            'id' => $this->getKey(),
            'title' => $this->title,
            'release_date' => (int) $this->release_date,
            'overview' => $this->overview,
            'updated_at' => $this->updated_at,

        ];
    }

    //public function addRating

    public function scopeFilter(Builder $builder, QueryFilter $filters)
    {
        return $filters->apply($builder);
    }

    public function scopeSearch(Builder $builder,string $terms)
    {
        return $builder->where('title',$terms);
    }

    public function countries()
    {
        return $this->belongsToMany(ProductionCountries::class);
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'film_genre');
    }

    public function likedByUsers()
    {
        return $this->belongsToMany(User::class, 'likes');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class,'film_id');
    }

    public function activities()
    {
        return $this->morphMany(Activity::class,'activitable');
    }
}
