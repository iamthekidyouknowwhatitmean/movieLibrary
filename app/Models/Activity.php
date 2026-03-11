<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Activity extends Model
{
    protected $guarded = [];

    public function activitable(): MorphTo
    {
        return $this->morphTo();
    }
}
