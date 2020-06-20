<?php

namespace NS\Auth\Models;

use Illuminate\Database\Eloquent\Model;

class AuthLog extends Model
{
    public const EVENT_LOGIN_SUCCESS = 1;
    public const EVENT_LOGIN_FAILED = 2;
    public const EVENT_OTHER = 3;

    protected string $table = 'auth_logs';

    protected array $timestamps = [
        'created_at',
    ];

    protected array $fillable = [
        'event',
        'ip',
        'username',
        'agent',
    ];
}
