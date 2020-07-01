<?php

namespace NS\User\Models;

use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailInterface;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use NS\User\Notifications\UsersNotification;


/**
 * @property integer id
 * @property integer status
 * @property bool is_active
 * @property bool is_banned
 * @property bool is_suspend
 * @method static create(array $array)
 */
class User extends Authenticatable implements MustVerifyEmailInterface
{
    use SoftDeletes;
    use Notifiable;
    use MustVerifyEmail;

    public const STATUS_ACTIVE = 1;
    public const STATUS_BANNED = 2;
    public const STATUS_SUSPEND = 3;

    public const ROLE_USER = 1;
    public const ROLE_ADMIN = 2;
    public const ROLE_MODERATOR = 3;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'login',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new UsersNotification());
    }


    public function getIsActiveAttribute(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    public function getIsBannedAttribute(): bool
    {
        return $this->status === self::STATUS_BANNED;
    }

    public function getIsSuspendAttribute(): bool
    {
        return $this->status === self::STATUS_SUSPEND;
    }
}
