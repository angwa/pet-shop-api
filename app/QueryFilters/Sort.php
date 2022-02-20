<?php

namespace App\QueryFilters;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Schema;

class Sort
{
    private $schemaTable;

    public function __construct($schemaTable)
    {
        $this->schemaTable = $schemaTable;
    }

    public function handle(Builder $query, Closure $next)
    {
        $sort = (!empty(request()->desc) && request()->desc == 'true') ? 'desc' : 'asc';

        //Below, we will try to check if user want to use sortBy and if the column he inserted really existed

        if (!empty(request()->sortBy) && Schema::hasColumn($this->schemaTable,  request()->sortBy)) {
            $query->orderBy(request()->sortBy, $sort);
        } else if (!empty(request()->desc)) {

            $query->orderBy('created_at', $sort);
        }

        return $next($query);
    }
}
