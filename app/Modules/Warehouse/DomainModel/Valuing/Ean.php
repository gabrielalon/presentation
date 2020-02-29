<?php

namespace App\Modules\Warehouse\DomainModel\Valuing;

use App\Modules\Warehouse\Application\Ean\Validator;

class Ean
{
    /** @var string */
    private $ean;

    /**
     * Ean constructor.
     * @param string $ean
     * @throws \InvalidArgumentException
     */
    private function __construct(string $ean)
    {
        Validator::newInstance()->assertEan($ean);
        $this->ean = $ean;
    }

    /**
     * @param string $ean
     * @return Ean
     * @throws \InvalidArgumentException
     */
    public static function fromString(string $ean): Ean
    {
        return new self($ean);
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return $this->ean;
    }
}
