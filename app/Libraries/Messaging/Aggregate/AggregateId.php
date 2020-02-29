<?php

namespace App\Libraries\Messaging\Aggregate;

interface AggregateId
{
    /**
     * @return string
     */
    public function toString(): string;
}
