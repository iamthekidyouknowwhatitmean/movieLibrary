<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class QueryFilter
{
    protected $request;
    protected $builder;
    protected $sortable = [];

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply(Builder $builder)
    {
        $this->builder = $builder;
        foreach ($this->request->all() as $key => $value) {
            if (method_exists($this, $key)) {
                $this->$key($value);
            }
        }

        return $this->builder;
    }

    protected function sort(string $value)
    {
        $sortAttributes = explode(',',$value);

        foreach($sortAttributes as $sortAttribute)
        {
            $direction = 'asc';

            if(strpos($sortAttribute,'-') === 0)
            {
                $direction = 'desc';
                $sortAttribute = substr($sortAttribute,1);
            }

            if(!in_array($sortAttribute,$this->sortable)){
                continue;
            }

            $this->builder->orderBy($sortAttribute,$direction);
        }

    }
}
