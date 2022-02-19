<?php

namespace App\Actions\User;

use App\Models\Order;
use App\QueryFilters\QueryFilter;

use App\Support\Collection;


class OrderListAction
{ 
    public function execute()
    {

        $limit = (!empty(request()->limit)) ? request()->limit : 30;

        $filter = (new QueryFilter(Order::class, 'orders'))->filter();
        $orders = (new Collection($filter))->paginate($limit);

        return $orders;
    }
}