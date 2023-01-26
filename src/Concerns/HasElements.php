<?php

namespace QueryBuilder\Concerns;

trait HasElements
{
    /**
     * Add checkbox input filter criteria.
     *
     * @param Illuminate\Database\Eloquent\Builder|Illuminate\Database\Query\Builder $builder
     * @param string                                                                 $name
     * @param string                                                                 $alias
     *
     * @return Illuminate\Database\Query\Builder
     */
    public function addCheckboxCriteria($builder, $name, $alias = '')
    {
        return ($this->make('checkbox'))
                    ->setParmaters($this->parameters)
                    ->setName($name)
                    ->setAlias($alias)
                    ->filter($builder);
    }

    /**
     * Add text input filter criteria.
     *
     * @param Illuminate\Database\Eloquent\Builder|Illuminate\Database\Query\Builder $builder
     * @param string                                                                 $name
     * @param string                                                                 $alias
     * @param string                                                                 $strict
     *
     * @return Illuminate\Database\Query\Builder
     */
    public function addTextCriteria($builder, $name, $alias = '', $strict = false)
    {
        return ($this->make('text'))
                    ->setParmaters($this->parameters)
                    ->setName($name)
                    ->setAlias($alias)
                    ->setStrict($strict)
                    ->filter($builder);
    }

    /**
     * Add date input filter criteria.
     *
     * @param Illuminate\Database\Eloquent\Builder|Illuminate\Database\Query\Builder $builder
     * @param string                                                                 $name
     * @param string                                                                 $alias
     *
     * @return Illuminate\Database\Query\Builder
     */
    public function addDateCriteria($builder, $name, $alias = '')
    {
        return ($this->make('date'))
                    ->setParmaters($this->parameters)
                    ->setName($name)
                    ->setAlias($alias)
                    ->filter($builder);
    }

    /**
     * Add select input filter criteria.
     *
     * @param Illuminate\Database\Eloquent\Builder|Illuminate\Database\Query\Builder $builder
     * @param string                                                                 $name
     * @param string                                                                 $alias
     * @param string                                                                 $multiple
     *
     * @return Illuminate\Database\Query\Builder
     */
    public function addSelectCriteria($builder, $name, $alias = '', $multiple = false)
    {
        return ($this->make('select'))
                    ->setParmaters($this->parameters)
                    ->setName($name)
                    ->setAlias($alias)
                    ->setMultiple($multiple)
                    ->filter($builder);
    }

    /**
     * Add date range input filter criteria.
     *
     * @param Illuminate\Database\Eloquent\Builder|Illuminate\Database\Query\Builder $builder
     * @param string                                                                 $name
     * @param string                                                                 $alias
     *
     * @return Illuminate\Database\Query\Builder
     */
    public function addDateRangeCriteria($builder, $name, $alias = '')
    {
        return ($this->make('date_range'))
                    ->setParmaters($this->parameters)
                    ->setName($name)
                    ->setAlias($alias)
                    ->filter($builder);
    }
}
