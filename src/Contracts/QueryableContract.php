<?php

namespace QueryBuilder\Contracts;

interface QueryableContract
{
    /**
     * Execute the query and get the first result.
     *
     * @param array $columns
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function first($columns = ['*']);

    /**
     * Execute the query as a "select" statement.
     *
     * @param array|string $columns
     *
     * @return \Illuminate\Support\Collection
     */
    public function get($columns = ['*']);

    /**
     * Gets the builder object.
     *
     * @return Illuminate\Database\Query\Builder
     */
    public function getBuilder();

    /**
     * Get query count.
     *
     * @return int
     */
    public function count();

    /**
     * Paginate the given query into a simple paginator.
     *
     * @param array $columns
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate($columns = ['*']);
}
