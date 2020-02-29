<?php

namespace App\Libraries\Messaging\Command;

interface CommandHandler
{
    /**
     * @param Command $command
     */
    public function run(Command $command): void;
}
