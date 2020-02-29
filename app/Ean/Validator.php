<?php

namespace App\Ean;

class Validator
{
    /**
     * @return Validator
     */
    public static function newInstance(): Validator
    {
        return new self();
    }

    /**
     * @param $ean
     * @return bool
     */
    public function isValid(string $ean): bool
    {
        $sumEvenIndexes = 0;
        $sumOddIndexes  = 0;

        $eanAsArray = array_map('intval', str_split($ean));

        if (!$this->has13Numbers($eanAsArray)) {
            return false;
        };

        for ($i = 0; $i < count($eanAsArray)-1; $i++) {
            if ($i % 2 === 0) {
                $sumOddIndexes  += $eanAsArray[$i];
            } else {
                $sumEvenIndexes += $eanAsArray[$i];
            }
        }

        $rest = ($sumOddIndexes + (3 * $sumEvenIndexes)) % 10;

        if ($rest !== 0) {
            $rest = 10 - $rest;
        }

        return $rest === $eanAsArray[12];
    }

    /**
     * @param array $ean
     * @return bool
     */
    private function has13Numbers(array $ean): bool
    {
        return count($ean) === 13;
    }
}
