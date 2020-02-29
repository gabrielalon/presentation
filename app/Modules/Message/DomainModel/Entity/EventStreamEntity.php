<?php

namespace App\Modules\Message\DomainModel\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $event_uuid
 * @property string $event_name
 * @property integer $version
 * @property string $payload
 * @property string $user_id
 */
class EventStreamEntity extends Model
{
    /** @var string */
    protected $table = 'event_storage';

    /** @var string[]  */
    protected $fillable = [
        'event_uuid',
        'event_name',
        'version',
        'payload',
        'user_id'
    ];
}
