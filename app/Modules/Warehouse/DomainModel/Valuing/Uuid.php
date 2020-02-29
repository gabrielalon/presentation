<?php

namespace App\Modules\Warehouse\DomainModel\Valuing;

use App\Libraries\Messaging\Aggregate\AggregateId;
use Webmozart\Assert\Assert;

class Uuid implements AggregateId
{
    /** @var string */
    private $uuid;

    /**
     * Uuid constructor.
     * @param string $uuid
     * @throws \InvalidArgumentException
     */
    private function __construct(string $uuid)
    {
        Assert::uuid($uuid);
        $this->uuid = $uuid;
    }

    /**
     * @param string $uuid
     * @return Uuid
     * @throws \InvalidArgumentException
     */
    public static function fromString(string $uuid): Uuid
    {
        return new self($uuid);
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return $this->uuid;
    }
}
