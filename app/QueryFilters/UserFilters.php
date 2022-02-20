<?php

namespace App\QueryFilters;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class UserFilters
{
    public function handle(Builder $query, Closure $next)
    {
        $query->where('is_admin', 0);

        if (!empty(request()->first_name)) {
            $query->where('first_name', request()->first_name);
        }

        if (!empty(request()->email)) {
            $query->where('email', request()->email);
        }

        if (!empty(request()->phone)) {
            $query->where('phone_number', request()->phone);
        }

        if (!empty(request()->address)) {
            $query->where('address', request()->address);
        }

        if (!empty(request()->created_at)) {
            $query->whereDate('created_at', Carbon::parse(request()->created_at));
        }

        if (!empty(request()->marketing)) {
            $query->where('is_marketing', request()->marketing);
        }

        return $next($query);
    }
}
