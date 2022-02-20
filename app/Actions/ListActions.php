<?php

namespace App\Actions;

use App\QueryFilters\FilterUserFields;
use App\QueryFilters\QueryFilter;
use App\QueryFilters\QueryFilterWithoutAuth;
use App\Support\Collection;

class ListActions
{
    private $schemaTable;
    private $schemaClass;
    public $limit;

    /**
     * @param mixed $schemaTable
     * @param mixed $schemaClass
     * The schema table is the table through which you want to filter
     * the schema class the is class instance of the same table as above
     */
    public function __construct($schemaClass, $schemaTable)
    {
        $this->schemaTable = $schemaTable;
        $this->schemaClass = $schemaClass;
        $this->limit = (!empty(request()->limit)) ? request()->limit : 30;
    }

    /**
     * @return object
     */
    public function sortWithoutAuth(): object
    {
        $filter = (new QueryFilterWithoutAuth($this->schemaClass, $this->schemaTable))->filter();
        $items = (new Collection($filter))->paginate($this->limit);

        return $items;
    }

    /**
     * @return object
     */
    public function sortWithAuth(): object
    {
        $filter = (new QueryFilter($this->schemaClass, $this->schemaTable))->filter();
        $items = (new Collection($filter))->paginate($this->limit);

        return $items;
    }

    /**
     * @return object
     */
    public function sortWithUserFields(): object
    {
        $filter = (new FilterUserFields($this->schemaClass, $this->schemaTable))->filter();
        $items = (new Collection($filter))->paginate($this->limit);

        return $items;
    }
}
