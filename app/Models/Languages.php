<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $iso_639_1
 * @property string $english_name
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Languages newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Languages newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Languages query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Languages whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Languages whereEnglishName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Languages whereIso6391($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Languages whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Languages whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Languages extends Model
{
    protected $guarded = [];
}
