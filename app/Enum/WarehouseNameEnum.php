<?php

namespace App\Enum;

/**
 * @method static WarehouseNameEnum MAIN()
 * @method static WarehouseNameEnum SPEDIMEX()
 * @method static WarehouseNameEnum ARVATO()
 * @method static WarehouseNameEnum CORRECTION()
 */
class WarehouseNameEnum extends \MyCLabs\Enum\Enum
{
    protected const MAIN        = 'main';
    protected const SPEDIMEX    = 'spedimex';
    protected const ARVATO      = 'arvato';
    protected const CORRECTION  = 'correction';
}
