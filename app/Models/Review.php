<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Review extends Model
{
    protected $guarded = [];

    public function activities()
    {
        return $this->morphMany(Activity::class,'activitable');
    }
}
