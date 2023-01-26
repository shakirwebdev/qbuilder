<?php

namespace QueryBuilder;

use Illuminate\Support\Str;
use QueryBuilder\Contracts\FilterContract;
use QueryBuilder\Exceptions\UnsupportedFilter;

class FilterBroker implements FilterContract
{
    use Concerns\HasElements;
    use Concerns\HasOperators;

    /**
     * Package default namespace.
     *
     * @var string
     */
    protected $namespace = 'QueryBuilder\Filters';

    /**
     * The parameters.
     *
     * @var array
     */
    protected $parameters;

    /**
     * Constructor.
     */
    public function __construct(array $parameters = [])
    {
        $this->parameters = collect($parameters);
    }

    /**
     * Set parameters.
     *
     * @return QueryBuilder\FilterBroker
     */
    public function setParameters(array $parameters)
    {
        $this->parameters = $parameters;

        return $this;
    }

    /**
     * Set namespace.
     *
     * @param string $namespace
     *
     * @return QueryBuilder\FilterBroker
     */
    public function setDefaultNamespace($namespace)
    {
        $this->namespace = $namespace;

        return $this;
    }

    /**
     * Make filter.
     *
     * @param string $input
     * @param array  ...$args
     *
     * @return QueryBuilder\QueryFilter
     */
    public function make($input, ...$args)
    {
        $namespace = $this->resolveClass($input);

        return new $namespace(...$args);
    }

    /**
     * Generic function for adding criterias.
     *
     * @param string                                                                   $input
     * @param Illuminate\Database\Eloquent\Builder | Illuminate\Database\Query\Builder $builder
     * @param string                                                                   $name
     * @param string                                                                   $alias
     * @param bool                                                                     $strict
     * @param bool                                                                     $multiple
     *
     * @return void
     */
    public function addCriteria($input, $builder, $name, $alias = '', $strict = false, $multiple = false)
    {
        if ($name instanceof \Closure) {
            return call_user_func_array($name, [$this, $builder]);
        }

        switch ($input) {
            case 'date_range':
                return $this->addDateRangeCriteria($builder, $name, $alias);
            case 'range':
                return $this->addRangeCriteria($builder, $name, $alias);
            case 'date':
                return $this->addDateCriteria($builder, $name, $alias);
            case 'text':
                return $this->addTextCriteria($builder, $name, $alias);
            case 'like':
                return $this->addLikeCriteria($builder, $name, $alias);
            case 'checkbox':
            case 'radio':
                return $this->addCheckboxCriteria($builder, $name, $alias);
            case 'boolean':
                return $this->addBooleanCriteria($builder, $name, $alias);
            case 'select':
                return $this->addSelectCriteria($builder, $name, $alias);
            case 'equal':
                return $this->addEqualCriteria($builder, $name, $alias);
            case 'multi_select':
                return $this->addSelectCriteria($builder, $name, $alias, true);
            case 'less_than_equal':
                return $this->addLessThanEqualCriteria($builder, $name, $alias, true);
            case 'less_than':
                return $this->addLessThanEqualCriteria($builder, $name, $alias);
            case 'greater_than_equal':
                return $this->addGreaterThanEqualCriteria($builder, $name, $alias, true);
            case 'greater_than':
                return $this->addGreaterThanEqualCriteria($builder, $name, $alias);
            default:
                return ($this->make($input, $name, $alias))
                        ->setParmaters($this->parameters)
                        ->filter($builder);
        }
    }

    /**
     * Resolve filter class from input.
     *
     * @param string $input
     *
     * @throws UnsupportedFilter
     *
     * @return string
     */
    protected function resolveClass($input)
    {
        $className = Str::studly($input).'Filter';

        $namespace = $this->namespace.'\\'.$className;
        if (class_exists($namespace)) {
            return $namespace;
        }

        throw new UnsupportedFilter('Filter not supported');
    }
}
