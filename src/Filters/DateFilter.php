<?php

namespace QueryBuilder\Filters;

use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use QueryBuilder\Contracts\FilterableContract;
use QueryBuilder\QueryFilter;

class DateFilter extends QueryFilter implements FilterableContract
{
    const TODAY = 'today';

    /**
     * Add filter to sql statement.
     *
     * @param Illuminate\Database\Eloquent\Builder | Illuminate\Database\Query\Builder $builder
     *
     * @return Illuminate\Database\Query\Builder
     */
    public function filter($builder)
    {
        $default = $this->getConfigValue();
        if (!$this->hasValue() && !$default) {
            return $builder;
        }

        [$table, $column] = $this->getTableAndColumn();

        if (!$table) {
            throw new Exception('Unknown instance of builder');
        }

        $value = $this->parameter->get($this->name);
        $column = $table.'.'.$column;
        if ($default && !$value) {
            $value = $default;
        }

        return $builder->where(DB::raw('DATE('.$column.')'), $value);
    }

    /**
     * Get Config default value.
     *
     * @return NULL/string
     */
    protected function getConfigValue()
    {
        $value = config('qbuilder.filters.date');
        if (self::TODAY == $value) {
            return new Carbon();
        }

        return;
    }
}
