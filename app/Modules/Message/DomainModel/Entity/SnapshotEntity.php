<?php

namespace App\Modules\Message\DomainModel\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $aggregate_uuid
 * @property string $aggregate_type
 * @property string $aggregate
 * @property integer $last_version
 */
class SnapshotEntity extends Model
{
    /** @var string */
    protected $table = 'snapshot_storage';

    /** @var bool */
    public $timestamps = false;

    /** @var string[]  */
    protected $fillable = [
        'aggregate_uuid',
        'aggregate_type',
        'aggregate',
        'last_version'
    ];
}
