<?php

namespace App\Modules\Warehouse\DomainModel\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $uuid
 * @property string $warehouse_uuid
 * @property string $item_uuid
 * @property integer $quantity
 *
 * @property WarehouseEntity $warehouse
 * @property WarehouseItemEntity $item
 */
class WarehouseStateEntity extends Model
{
    /** @var string */
    protected $table = 'warehouse_state';

    /** @var string */
    protected $primaryKey = 'warehouse_uuid';

    /** @var bool */
    public $incrementing = false;

    /** @var bool */
    public $timestamps = false;

    /** @var string */
    protected $keyType = 'string';

    /** @var string[]  */
    protected $fillable = [
        'uuid',
        'warehouse_uuid',
        'item_uuid',
        'quantity'
    ];

    /**
     * @return BelongsTo
     */
    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(WarehouseEntity::class, 'warehouse_uuid', 'uuid');
    }

    /**
     * @return BelongsTo
     */
    public function item(): BelongsTo
    {
        return $this->belongsTo(WarehouseItemEntity::class, 'item_uuid', 'uuid');
    }
}

