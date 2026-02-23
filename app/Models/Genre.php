<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    protected $guarded = [];

    protected $primaryKey = 'tmdb_id';
    public $incrementing = false;
    protected $keyType = 'int';
}
