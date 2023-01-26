<?php

namespace QueryBuilder\Filters;

use Exception;
use QueryBuilder\Contracts\FilterableContract;
use QueryBuilder\QueryFilter;

class CheckboxFilter extends QueryFilter implements FilterableContract
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
            throw new Exception('Unknown instance of builder');
        }

        return $builder->where(
            $table.'.'.$column,
            $this->parameter->get($this->name)
        );
    }
}
