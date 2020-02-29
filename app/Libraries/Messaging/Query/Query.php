<?php

namespace App\Libraries\Messaging\Query;

use App\Libraries\Messaging\Message;

abstract class Query implements Message
{
    /**
     * @inheritdoc
     */
    public function messageName(): string
    {
        return \get_called_class();
    }
}
