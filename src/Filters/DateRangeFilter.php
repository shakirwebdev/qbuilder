<?php

namespace QueryBuilder\Filters;

use Carbon\Carbon;
use QueryBuilder\Contracts\FilterableContract;

class DateRangeFilter extends DateFilter implements FilterableContract
{
    const WEEKS = 'weeks';
    const MONTHS = 'months';
    const YEARS = 'years';

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

        $column = $table.'.'.$column;
        $value = $this->parameter->get($this->name);

        $range = $this->parseDate($value);

        $range[1] = isset($range[1]) ? $range[1] : $range[0];
        $from = (new Carbon($range[0]))->startOfDay();
        $to = (new Carbon($range[1]))->endOfDay();

        return $builder->whereBetween($column, [$from, $to]);
    }

    /**
     * Parse date.
     *
     * @param unknown $value
     *
     * @return array
     */
    protected function parseDate($value)
    {
        return explode(config('qbuilder.filters.date_range.delimeter'), $value);
    }
}
