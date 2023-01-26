<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Query Parameters
    |--------------------------------------------------------------------------
    |
    | These are the keys used for parsing the query parameters.
    */
    'parameters' => [
        'include' => 'include',
        'filter' => 'filter',
        'sort' => 'sort',
        'field' => 'field',
        'page' => 'page',
        'limit' => 'limit',
    ],

    /*
    |--------------------------------------------------------------------------
    | Filter components
    |--------------------------------------------------------------------------
    |
    | This is where the default values for components are configured
    |
    */
    'filters' => [
        'date_range' => [
            'delimeter' => ',', // 2019-02-01, 2019-02-03
        ],
        'date' => null,
    ],

    /*
    |--------------------------------------------------------------------------
    | Pagination default
    |--------------------------------------------------------------------------
    |
    | This is where the pagination default can be set
    |
    */
    'pagination' => [
        'signs' => [
            '-' => 'desc',
            '+' => 'asc',
        ],
        'default' => [
            'page' => '50',
            'sort' => 'asc',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Delimeter
    |--------------------------------------------------------------------------
    |
    | This is the delimter used when passing multiple data
    |
    */
    'delimeter' => ',',
];
