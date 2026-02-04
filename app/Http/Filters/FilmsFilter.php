<?php

namespace App\Http\Filters;

class FilmsFilter extends QueryFilter
{
    public function category(string $value)
    {
        $this->builder->where('category', $value);
    }
}
