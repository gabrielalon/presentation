<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string $uuid
 * @property string $name
 *
 * @property Collection $states
 */
class Warehouse extends Model
{
    use SoftDeletes;

    /** @var string */
    protected $table = 'warehouse';

    /** @var string */
    protected $primaryKey = 'uuid';

    /** @var bool */
    public $incrementing = false;

    /** @var bool */
    public $timestamps = false;

    /** @var string */
    protected $keyType = 'string';

    /** @var string[]  */
    protected $fillable = [
        'uuid',
        'name'
    ];

    /**
     * @return HasMany
     */
    public function states(): HasMany
    {
        return $this->hasMany(WarehouseState::class, 'warehouse_uuid', 'uuid');
    }
}
