<?php

namespace QueryBuilder;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

abstract class QueryFilter
{
    /**
     * Filter name.
     *
     * @var string
     */
    protected $name;

    /**
     * Set strict comparison.
     *
     * @var bool
     */
    protected $strict = false;

    /**
     * Set can hold multiple.
     *
     * @var bool
     */
    protected $multiple = false;

    /**
     * Set filter alias.
     *
     * @var string
     */
    protected $alias;

    /**
     * The parameters.
     *
     * @var string
     */
    protected $parameter;

    /**
     * Constructor.
     *
     * @param string $name
     * @param string $alias
     * @param bool   $strict
     * @param bool   $multiple
     */
    public function __construct($name = null, $alias = null, $strict = false, $multiple = false)
    {
        $this->setName($name);
        $this->setAlias($alias);
        $this->setStrict($strict);
        $this->setMultiple($multiple);
        $this->parameter = collect();
    }

    /**
     * Set the parameters.
     *
     * @return QueryBuilder\QueryFilter
     */
    public function setParmaters(array $params)
    {
        $this->parameter = collect($params);

        return $this;
    }

    /**
     * Get parameters.
     *
     * @return array
     */
    public function getParameters()
    {
        return $this->parameter;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return QueryBuilder\QueryFilter
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set strict.
     *
     * @param string $strict
     *
     * @return QueryBuilder\QueryFilter
     */
    public function setStrict($strict)
    {
        $this->strict = $strict;

        return $this;
    }

    /**
     * Get strict.
     *
     * @return bool
     */
    public function getStrict()
    {
        return $this->strict;
    }

    /**
     * Set multiple.
     *
     * @param string $multiple
     *
     * @return QueryBuilder\QueryFilter
     */
    public function setMultiple($multiple)
    {
        $this->multiple = $multiple;

        return $this;
    }

    /**
     * Get multiple.
     *
     * @return bool
     */
    public function getMultiple()
    {
        return $this->multiple;
    }

    /**
     * Set alias.
     *
     * @param string $alias
     *
     * @return QueryBuilder\QueryFilter
     */
    public function setAlias($alias)
    {
        $this->alias = $alias;

        return $this;
    }

    /**
     * Get alias.
     *
     * @return string
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * Get table name.
     *
     * @param string $builder
     *
     * @return string
     */
    protected function getTableName($builder)
    {
        $table = '';
        if ($builder instanceof Model) {
            $table = $builder->getTable();
        } elseif ($builder instanceof Builder) {
            $table = $builder->from;
        } else {
            $table = $builder->getModel()->getTable();
        }

        return $table;
    }

    /**
     * Check if filter has value.
     *
     * @return bool
     */
    protected function hasValue()
    {
        return !$this->name
            || $this->parameter->has($this->name)
            || 0 === strlen($this->parameter->get($this->name));
    }

    /**
     * Get table and column.
     *
     * @return array
     */
    protected function getTableAndColumn()
    {
        $table = '';
        $column = '';
        if ($this->alias) {
            if (false !== strpos($this->alias, '.')) {
                [$table, $column] = explode('.', $this->alias);
            } else {
                $column = $this->alias;
                $table = $this->getTableName($builder);
            }
        } else {
            $table = $this->getTableName($builder);
            $column = $this->name;
        }

        return [$table, $column];
    }
}
