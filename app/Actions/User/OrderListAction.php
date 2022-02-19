<?php

namespace App\Actions\User;

use App\Models\Order;
use App\QueryFilters\AuthUserFilter;
use App\QueryFilters\Sort;
use App\QueryFilters\Limit;
use Illuminate\Pipeline\Pipeline;


class OrderListAction
{ 
    public function execute()
    {
        $orders = app(Pipeline::class)
                ->send(Order::query())
                ->through([
                    new Sort('orders'),
                    Limit::class,
                    AuthUserFilter::class,
                ])
                ->thenReturn()
                ->paginate();

        return $orders;
    }
}