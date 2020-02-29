<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $warehouse_uuid
 * @property string $item_uuid
 * @property integer $quantity
 *
 * @property Warehouse $warehouse
 * @property WarehouseItem $item
 */
class WarehouseState extends Model
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
        'warehouse_uuid',
        'item_uuid',
        'quantity'
    ];

    /**
     * @return BelongsTo
     */
    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class, 'uuid', 'warehouse_uuid');
    }

    /**
     * @return BelongsTo
     */
    public function item(): BelongsTo
    {
        return $this->belongsTo(WarehouseItem::class, 'uuid', 'warehouse_uuid');
    }
}
