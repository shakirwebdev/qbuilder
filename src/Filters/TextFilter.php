<?php

namespace QueryBuilder\Filters;

use QueryBuilder\Contracts\FilterableContract;
use QueryBuilder\QueryFilter;

class TextFilter extends QueryFilter implements FilterableContract
{
    /**
     * Add filter to sql statement.
     *
     * @param Illuminate\Database\Eloquent\Builder | Illuminate\Database\Query\Builder $builder
     *
     * @return Illuminate\Database\Query\Builder
     */
    public function filter($builder)
    {
        if (!$this->hasValue()) {
            return $builder;
        }

        [$table, $column] = $this->getTableAndColumn();

        if (!$table) {
            throw new \Exception('Unknown instance of builder');
        }

        $value = $this->parameter->get($this->name);
        $column = $table.'.'.$column;

        if ($this->strict) {
            return $builder->where($column, $value);
        }

        return $builder->where($column, 'like', '%'.$value.'%');
    }
}
