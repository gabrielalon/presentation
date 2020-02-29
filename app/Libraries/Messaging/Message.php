<?php

namespace App\Libraries\Messaging;

interface Message
{
    /**
     * @return string
     */
    public function messageName(): string;
}
