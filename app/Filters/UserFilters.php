<?php

namespace App\Filters;
use App\User;

class UserFilters extends Filters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = ['state'];

    /**
     * Filter the query by the state of a user
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function state($state)
    {
        return $this->builder->where('state', $state);
    }
}