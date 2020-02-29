<?php

namespace App\Libraries\Messaging\Command;

use App\Libraries\Messaging\Message;

abstract class Command implements Message
{
    /**
     * @inheritdoc
     */
    public function messageName(): string
    {
        return \get_called_class();
    }
}
