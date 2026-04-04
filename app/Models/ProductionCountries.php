<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $iso_3166_1
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductionCountries newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductionCountries newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductionCountries query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductionCountries whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductionCountries whereIso31661($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductionCountries whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductionCountries whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ProductionCountries extends Model
{
    protected $guarded = [];
}
