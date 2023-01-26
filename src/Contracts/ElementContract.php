<?php

namespace QueryBuilder\Contracts;

interface ElementContract
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
    public function addCheckboxCriteria($builder, $name, $alias = '');

    /**
     * Add text input filter criteria.
     *
     * @param Illuminate\Database\Eloquent\Builder | Illuminate\Database\Query\Builder $builder
     * @param string                                                                   $name
     * @param string                                                                   $alias
     * @param string                                                                   $strict
     *
     * @return Illuminate\Database\Query\Builder
     */
    public function addTextCriteria($builder, $name, $alias = '', $strict = false);

    /**
     * Add date input filter criteria.
     *
     * @param Illuminate\Database\Eloquent\Builder | Illuminate\Database\Query\Builder $builder
     * @param string                                                                   $name
     * @param string                                                                   $alias
     *
     * @return Illuminate\Database\Query\Builder
     */
    public function addDateCriteria($builder, $name, $alias = '');

    /**
     * Add select input filter criteria.
     *
     * @param Illuminate\Database\Eloquent\Builder | Illuminate\Database\Query\Builder $builder
     * @param string                                                                   $name
     * @param string                                                                   $alias
     * @param string                                                                   $multiple
     *
     * @return Illuminate\Database\Query\Builder
     */
    public function addSelectCriteria($builder, $name, $alias = '', $multiple = false);

    /**
     * Add date range input filter criteria.
     *
     * @param Illuminate\Database\Eloquent\Builder | Illuminate\Database\Query\Builder $builder
     * @param string                                                                   $name
     * @param string                                                                   $alias
     *
     * @return Illuminate\Database\Query\Builder
     */
    public function addDateRangeCriteria($builder, $name, $alias = '');
}
