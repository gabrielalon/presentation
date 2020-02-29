<?php

namespace App\Libraries\Messaging\Query;

interface QueryHandler
{
    /**
     * @param Query $query
     * @return Viewable
     */
    public function run(Query $query): Viewable;
}
