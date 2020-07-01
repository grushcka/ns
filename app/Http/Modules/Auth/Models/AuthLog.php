<?php

namespace NS\Auth\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $array)
 */
class AuthLog extends Model
{
    public const EVENT_LOGIN_SUCCESS = 1;
    public const EVENT_LOGIN_FAILED = 2;
    public const EVENT_OTHER = 3;

    protected $table = 'auth_logs';

    //disabled update_at
    public const UPDATED_AT = null;

    protected $fillable = [
        'event',
        'ip',
        'username',
        'agent',
    ];

    public static function saveEvent($event, $user, $ip, $agent): void
    {
        self::create(
            [
                'event' => $event,
                'username' => $user,
                'ip' => $ip,
                'agent' => $agent,
            ]
        );
    }
}
