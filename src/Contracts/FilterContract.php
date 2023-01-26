<?php

namespace QueryBuilder\Contracts;

interface FilterContract extends ElementContract, OperatorContract
{
    /**
     * Make a filter object.
     *
     * @param string $input
     * @param array  ...$args
     *
     * @return QueryBuilder\QueryFilter
     */
    public function make($input, ...$args);

    /**
     * Add dynamic input filter criteria.
     *
     * @param string                                                                   $input
     * @param Illuminate\Database\Eloquent\Builder | Illuminate\Database\Query\Builder $builder
     * @param string                                                                   $name
     * @param string                                                                   $alias
     * @param bool                                                                     $strict
     * @param bool                                                                     $multiple
     *
     * @return Illuminate\Database\Query\Builder
     */
    public function addCriteria($input, $builder, $name, $alias = '', $strict = false, $multiple = false);
}
