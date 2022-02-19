<?php

namespace App\Actions\Product;

use App\Models\Product;
use App\QueryFilters\QueryFilterWithoutAuth;
use App\Support\Collection;

class AllProductsAction
{
    public function execute()
    {

        $limit = (!empty(request()->limit)) ? request()->limit : 30;

        $filter = (new QueryFilterWithoutAuth(Product::class, 'products'))->filter();
        $products = (new Collection($filter))->paginate($limit);

        return $products;
    }
}