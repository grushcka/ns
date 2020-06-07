<?php

namespace NS\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

/**
 * Class Video
 * @package NS\Models
 * @property User $owner
 * @property Channel $channel
 * @property Collection $comments
 */
class Video extends Model
{
    use SoftDeletes;

    protected const DELETED_AT = 'deleted_at';

    /**
     * @var string $table
     */
    public string $table = 'videos';

    /**
     * @var array $fillable
     */
    protected array $fillable = [
        'name',
        'title',
        'description',
        'status',
        'owner_id',
        'channel_id',
    ];

    /**
     * @return BelongsTo
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo('users', 'id', 'owner_id');
    }

    /**
     * @return BelongsTo
     */
    public function channel(): BelongsTo
    {
        return $this->belongsTo('channels', 'id', 'channel_id');
    }

    /**
     * @return HasMany
     */
    public function comments(): HasMany
    {
        return $this->hasMany('comments', 'video_id', 'id');
    }
}
