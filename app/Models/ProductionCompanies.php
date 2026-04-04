<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string|null $logo_path
 * @property string $name
 * @property string $origin_country
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductionCompanies newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductionCompanies newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductionCompanies query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductionCompanies whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductionCompanies whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductionCompanies whereLogoPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductionCompanies whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductionCompanies whereOriginCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductionCompanies whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ProductionCompanies extends Model
{
    protected $guarded = [];
    protected $table = 'companies';

}
