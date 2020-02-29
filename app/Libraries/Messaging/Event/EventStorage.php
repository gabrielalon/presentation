<?php

namespace App\Libraries\Messaging\Event;

use App\Libraries\Messaging\Aggregate\AggregateChanged;
use App\Libraries\Messaging\Aggregate\AggregateId;

class EventStorage
{
    /** @var EventPublisher */
    private $eventPublisher;

    /** @var EventStreamRepository */
    private $streamRepository;

    /** @var AggregateChanged */
    private $tmpLastReleasedEvent;

    /**
     * EventStorage constructor.
     * @param EventPublisher $eventPublisher
     * @param EventStreamRepository $streamRepository
     */
    public function __construct(EventPublisher $eventPublisher, EventStreamRepository $streamRepository)
    {
        $this->eventPublisher = $eventPublisher;
        $this->streamRepository = $streamRepository;
    }

    /**
     * @param AggregateChanged $event
     * @return EventStorage
     * @throws \ReflectionException
     */
    public function release(AggregateChanged $event): EventStorage
    {
        $this->eventPublisher->release($event);

        $this->tmpLastReleasedEvent = $event;

        return $this;
    }

    public function record(): void
    {
        if (null !== $this->tmpLastReleasedEvent) {
            $this->streamRepository->save($this->tmpLastReleasedEvent);
        }
    }

    /**
     * @param AggregateId $aggregateId
     * @param int $lastVersion
     * @return \ArrayIterator
     */
    public function load(AggregateId $aggregateId, int $lastVersion)
    {
        $iterator = new \ArrayIterator();

        foreach ($this->streamRepository->load($aggregateId, $lastVersion) as $event) {
            $iterator->append($event);
        }

        return $iterator;
    }
}
