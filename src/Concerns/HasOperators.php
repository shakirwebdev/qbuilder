<?php

namespace QueryBuilder\Concerns;

trait HasOperators
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
    public function addBooleanCriteria($builder, $name, $alias = '')
    {
        return ($this->make('checkbox'))
                    ->setParmaters($this->parameters)
                    ->setName($name)
                    ->setAlias($alias)
                    ->filter($builder);
    }

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
    public function addLessThanEqualCriteria($builder, $name, $alias = '', $strict = false)
    {
        return ($this->make('less_than_equal'))
                    ->setParmaters($this->parameters)
                    ->setName($name)
                    ->setStrict($strict)
                    ->setAlias($alias)
                    ->filter($builder);
    }

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
    public function addGreaterThanEqualCriteria($builder, $name, $alias = '', $strict = false)
    {
        return ($this->make('greater_than_equal'))
                    ->setParmaters($this->parameters)
                    ->setName($name)
                    ->setStrict($strict)
                    ->setAlias($alias)
                    ->filter($builder);
    }

    /**
     * Add equal criteria.
     *
     * @param Illuminate\Database\Eloquent\Builder | Illuminate\Database\Query\Builder $builder
     * @param string                                                                   $name
     * @param string                                                                   $alias
     *
     * @return Illuminate\Database\Query\Builder
     */
    public function addEqualCriteria($builder, $name, $alias = '')
    {
        return ($this->make('text'))
                    ->setParmaters($this->parameters)
                    ->setName($name)
                    ->setAlias($alias)
                    ->setStrict(true)
                    ->filter($builder);
    }

    /**
     * Add range criteria.
     *
     * @param Illuminate\Database\Eloquent\Builder | Illuminate\Database\Query\Builder $builder
     * @param string                                                                   $name
     * @param string                                                                   $alias
     *
     * @return Illuminate\Database\Query\Builder
     */
    public function addRangeCriteria($builder, $name, $alias = '')
    {
        return ($this->make('date_range'))
                    ->setParmaters($this->parameters)
                    ->setName($name)
                    ->setAlias($alias)
                    ->filter($builder);
    }

    /**
     * Add like criteria.
     *
     * @param Illuminate\Database\Eloquent\Builder | Illuminate\Database\Query\Builder $builder
     * @param string                                                                   $name
     * @param string                                                                   $alias
     *
     * @return Illuminate\Database\Query\Builder
     */
    public function addLikeCriteria($builder, $name, $alias = '')
    {
        return ($this->make('text'))
                ->setParmaters($this->parameters)
                ->setName($name)
                ->setAlias($alias)
                ->filter($builder);
    }
}
