<?php

namespace App\Modules\Warehouse\DomainModel\Entity;

use App\Modules\Warehouse\DomainModel\Enum\NameEnum;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string $uuid
 * @property NameEnum $name
 *
 * @property Collection $states
 */
class WarehouseEntity extends Model
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
     * @return NameEnum
     */
    public function getNameAttribute(): NameEnum
    {
        return new NameEnum($this->attributes['name']);
    }

    /**
     * @return HasMany
     */
    public function states(): HasMany
    {
        return $this->hasMany(WarehouseStateEntity::class, 'warehouse_uuid', 'uuid');
    }
}
