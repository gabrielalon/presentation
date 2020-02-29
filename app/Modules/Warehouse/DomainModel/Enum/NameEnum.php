<?php

namespace App\Modules\Warehouse\DomainModel\Enum;

/**
 * @method static NameEnum MAIN()
 * @method static NameEnum SPEDIMEX()
 * @method static NameEnum ARVATO()
 * @method static NameEnum CORRECTION()
 */
class NameEnum extends \MyCLabs\Enum\Enum
{
    protected const MAIN        = 'main';
    protected const SPEDIMEX    = 'spedimex';
    protected const ARVATO      = 'arvato';
    protected const CORRECTION  = 'correction';
}
