<?php

namespace App\Actions\Category;

use App\Models\Category;
use App\QueryFilters\QueryFilterWithoutAuth;
use App\Support\Collection;

class ListCategoryAction
{
    public function execute()
    {
        $limit = (!empty(request()->limit)) ? request()->limit : 30;

        $filter = (new QueryFilterWithoutAuth(Category::class, 'categories'))->filter();
        $categories = (new Collection($filter))->paginate($limit);

        return $categories;
    }
}