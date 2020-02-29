<?php

namespace App\Libraries\Messaging;

use Psr\Container\ContainerInterface;

class MessageBus
{
    /** @var ContainerInterface */
    private $container;

    /**
     * MessageBus constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param Command\Command $command
     */
    public function handle(Command\Command $command): void
    {
        $handlerName = $command->messageName() . 'Handler';

        /** @var Command\CommandHandler $handler */
        $handler = $this->container->get($handlerName);
        $handler->run($command);
    }

    /**
     * @param Query\Query $query
     * @return Query\Viewable
     */
    public function query(Query\Query $query): Query\Viewable
    {
        $handlerName = $query->messageName() . 'Handler';

        /** @var Query\QueryHandler $handler */
        $handler = $this->container->get($handlerName);
        return $handler->run($query);
    }
}
