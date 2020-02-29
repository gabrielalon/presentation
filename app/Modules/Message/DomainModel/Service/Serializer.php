<?php

namespace App\Modules\Message\DomainModel\Service;

interface Serializer
{
    /**
     * @param array $data
     * @return string
     */
    public function encode(array $data): string;

    /**
     * @param string $json
     * @return array
     */
    public function decode(string $json): array;
}
