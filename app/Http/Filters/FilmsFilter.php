<?php

namespace App\Http\Filters;

class FilmsFilter extends QueryFilter
{
    protected $sortable = [
        'popularity',
        'vote_average',
        'release_date'
    ];
    public function category(string $value)
    {
        $this->builder->where('category', $value);
    }

    public function genre(string $value)
    {
        $genres = explode(',',$value);

        $this->builder->whereHas('genres',function($relation) use ($genres){
            $relation->whereIn('name',$genres);
        })->with('genres')->get();
    }

    public function rating(string $value)
    {
        $ratings = explode(',',$value);
        $this->builder->whereBetween('vote_average',[$ratings[0],$ratings[1]]);
    }
}
