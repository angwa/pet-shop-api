<?php
namespace App\QueryFilters;

use Closure;
use Illuminate\Database\Eloquent\Builder;
class Limit 
{
    public function handle(Builder $query, Closure $next)
    {
        if(!empty(request()->limit))
        {
            $query->take(request()->limit);
        }
        return $next($query);
    }

}