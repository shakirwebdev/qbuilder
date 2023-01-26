<?php

namespace QueryBuilder\Contracts;

interface OperatorContract
{
    /**
     * Add checkbox input filter criteria.
     *
     * @param Illuminate\Database\Eloquent\Builder | Illuminate\Database\Query\Builder $builder
     * @param string                                                                   $name
     * @param string                                                                   $alias
     *
     * @return Illuminate\Database\Query\Builder
     */
    public function addBooleanCriteria($builder, $name, $alias = '');

    /**
     * Add less than equal operation.
     *
     * @param Illuminate\Database\Eloquent\Builder | Illuminate\Database\Query\Builder $builder
     * @param string                                                                   $name
     * @param string                                                                   $alias
     * @param bool                                                                     $strict
     *
     * @return Illuminate\Database\Query\Builder
     */
    public function addLessThanEqualCriteria($builder, $name, $alias = '', $strict = false);

    /**
     * Add greater than equal operation.
     *
     * @param Illuminate\Database\Eloquent\Builder | Illuminate\Database\Query\Builder $builder
     * @param string                                                                   $name
     * @param string                                                                   $alias
     * @param bool                                                                     $strict
     *
     * @return Illuminate\Database\Query\Builder
     */
    public function addGreaterThanEqualCriteria($builder, $name, $alias = '', $strict = false);

    /**
     * Add equal criteria.
     *
     * @param Illuminate\Database\Eloquent\Builder | Illuminate\Database\Query\Builder $builder
     * @param string                                                                   $name
     * @param string                                                                   $alias
     *
     * @return Illuminate\Database\Query\Builder
     */
    public function addEqualCriteria($builder, $name, $alias = '');

    /**
     * Add range criteria.
     *
     * @param Illuminate\Database\Eloquent\Builder | Illuminate\Database\Query\Builder $builder
     * @param string                                                                   $name
     * @param string                                                                   $alias
     *
     * @return Illuminate\Database\Query\Builder
     */
    public function addRangeCriteria($builder, $name, $alias = '');

    /**
     * Add like criteria.
     *
     * @param Illuminate\Database\Eloquent\Builder | Illuminate\Database\Query\Builder $builder
     * @param string                                                                   $name
     * @param string                                                                   $alias
     *
     * @return Illuminate\Database\Query\Builder
     */
    public function addLikeCriteria($builder, $name, $alias = '');
}
