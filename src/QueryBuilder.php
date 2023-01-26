<?php

namespace QueryBuilder;

use Genesis\Adhoc\DynamicAttribute;
use Genesis\Paginations\DatabasePagination;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Traits\Macroable;
use QueryBuilder\Contracts\QueryableContract;

abstract class QueryBuilder implements QueryableContract
{
    use DynamicAttribute;
    use Macroable;
    use DatabasePagination { paginate as protected DBPaginate; }

    /**
     * The query builder object.
     *
     * @var Illuminate\Database\Query\Builder
     */
    protected $builder;

    /**
     * The parameters.
     *
     * @var array
     */
    protected $parameters;

    /**
     * The filters.
     *
     * @var array
     */
    protected $filters = [
        /***
         * Example format
         *
         *  'created_at' => [
         *	    'filter' => 'date_range',
         *	    'table' => 'users',
         *		'column' => 'created_at' // refers to table column. If empty or not set the key will be used
         *	]
         *
         */
    ];

    /**
     * List of allowed model relations.
     *
     * @var array
     */
    protected $relations = [];

    /**
     * Only the fields defined can be selected in relations.
     *
     * @var array
     */
    protected $fields = [];

    /**
     * Prepared query flag.
     *
     * @var bool
     */
    protected $isPrepared = false;

    /**
     * The filter broker.
     *
     * @var QueryBuilder\FilterBroker
     */
    protected $filterBroker;

    /**
     * The parameter config.
     *
     * @var array
     */
    protected $paramConfig;

    /**
     * The pagination config.
     *
     * @var array
     */
    protected $paginationConfig;

    /**
     * The data delimeter.
     *
     * @var string
     */
    protected $delimeter = ',';

    /**
     * The default namespace.
     *
     * @var string
     */
    protected $defaultNamespace = 'QueryBuilder\\Filters';

    /**
     * Create instance.
     */
    public function __construct(FilterBroker $broker, array $parameters = [])
    {
        $this->parameters = $parameters;
        $this->paramConfig = config('qbuilder.parameters');
        $this->paginationConfig = config('qbuilder.pagination');
        $this->filterBroker = $broker->setParameters(
            $parameters[$this->paramConfig['filter']]
                                    ?? $parameters
        );
        $this->defaultLimit = $this->paginationConfig['default']['page'];
        $this->defaultOrder = $this->paginationConfig['default']['sort'];
        $this->limitAttribute = $this->paramConfig['limit'];
        $this->pageName = $this->paramConfig['page'];
        $this->delimeter = config('qbuilder.delimeter');
    }

    /**
     * Process data before sleeping.
     *
     * @return array
     */
    public function __sleep()
    {
        // PDO objects are unserializable, so needs to be unset
        $this->builder = null;
        $this->filterBroker = null;

        return ['parameters', 'filters', 'relations', 'fields'];
    }

    /**
     * Inititalises data when waking up.
     */
    public function __wakeup()
    {
        $this->builder = $this->query();
        $this->filterBroker = resolve(FilterBroker::class)->setParameters($this->parameters);
    }

    /**
     * Set parameters.
     *
     * @param mixed $params
     */
    public function setParameters($params)
    {
        if ($params instanceof Arrayable) {
            $params = $params->toArray();
        }
        $this->parameters = $params;

        $this->filterBroker->setParameters($params[$this->paramConfig['filter']] ?? []);

        return $this;
    }

    /**
     * Get the parameters.
     *
     * @return unknown
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * Execute the query and get the first result.
     *
     * @param array $columns
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function first($columns = ['*'])
    {
        return $this->getBuilder()->first($columns);
    }

    /**
     * Execute the query as a "select" statement.
     *
     * @param array|string $columns
     *
     * @return \Illuminate\Support\Collection
     */
    public function get($columns = ['*'])
    {
        return $this->getBuilder()->get($columns);
    }

    /**
     * Gets the builder object.
     *
     * @return Illuminate\Database\Query\Builder
     */
    public function getBuilder()
    {
        if (!$this->isPrepared) {
            $this->build();
        }

        return $this->builder;
    }

    /**
     * Paginate the given query into a simple paginator.
     *
     * @param array $columns
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate($columns = ['*'])
    {
        return $this->DBPaginate($this->getBuilder(), $this->parameters, $columns);
    }

    /**
     * Generates the base query.
     *
     * @return Builder
     */
    abstract public function query();

    /**
     * Adhoc processes before build.
     */
    public function beforeBuild()
    {
        // Do extra process before building the query here
    }

    /**
     * {@inheritDoc}
     *
     * @see \QueryBuilder\Contracts\QueryableContract::count()
     */
    public function count()
    {
        return $this->getBuilder()->count();
    }

    /**
     * Adhoc process after build.
     */
    public function afterBuild()
    {
        // Do extra process after building the query here
    }

    /**
     * Get sort symbols.
     *
     * @return array
     */
    public function getOrderSigns()
    {
        return $this->paginationConfig['signs'];
    }

    /**
     * Build the query builder.
     */
    protected function build()
    {
        $this->builder = $this->query();

        $this->beforeBuild();
        $this->buildFilters();
        $this->buildRelations();
        $this->afterBuild();

        $this->isPrepared = true;

        return $this;
    }

    /**
     * Filter the data base from lookup fields.
     *
     * @param string $relation
     *
     * @return array
     */
    protected function filterFields($relation, array $fields)
    {
        return array_intersect($this->fields[$relation], $fields);
    }

    /**
     * Build relations.
     *
     * @return void
     */
    protected function buildRelations()
    {
        $withs = [];
        $includes = $this->parameters[$this->paramConfig['include']] ?? '';
        $relations = explode($this->delimeter, $includes);
        foreach ($relations as $relation) {
            if (in_array($relation, $this->relations)) {
                $selects = $this->parameters[$this->paramConfig['field']] ?? [];
                if (array_key_exists($relation, $selects) &&
                    array_key_exists($relation, $this->fields)) {
                    $fields = explode($this->delimeter, $selects[$relation]);
                    $fields = $this->filterFields($relation, $fields);
                    $withs[] = $relation.':'.implode($this->delimeter, $fields);
                } else {
                    $withs[] = $relation;
                }
            }
        }

        if ($withs) {
            $this->builder->with($withs);
        }
    }

    /**
     * Build the filters.
     */
    protected function buildFilters()
    {
        foreach ($this->filters as $key => $value) {
            if (isset($this->parameters[$this->paramConfig['filter']][$key])) {
                $column = isset($value['column']) ? $value['column'] : $key;
                $alias = $value['table'].'.'.$column;

                if (isset($value['namespace'])) {
                    $this->filterBroker
                    ->setDefaultNamespace($value['namespace'])
                    ->addCriteria(
                        $value['filter'],
                        $this->builder,
                        $key,
                        $alias
                    );
                } else {
                    $this->filterBroker
                    ->setDefaultNamespace($this->defaultNamespace)
                    ->addCriteria(
                        $value['filter'],
                        $this->builder,
                        $key,
                        $alias
                    );
                }
            }
        }
    }
}
