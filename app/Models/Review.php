<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Laravel\Scout\Searchable;

class Review extends Model
{
    use Searchable;

    protected $guarded = [];

    public function toSearchableArray()
    {
        return [
            'id' => $this->getKey(),
            'body' => $this->body
        ];
    }

    public function activities()
    {
        return $this->morphMany(Activity::class,'activitable');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
