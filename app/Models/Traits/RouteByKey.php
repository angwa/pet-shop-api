<?php

namespace App\Models\Traits;

trait RouteByKey
{
    public function getRouteKeyName()
    {
        return 'uuid';
    }

}