<?php

namespace NS\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * Class Channel
 * User Channels
 * @package NS
 * @property string $name
 * @property string $title
 * @property string $description
 * @property User $owner
 * @property Collection $videos
 */
class Channel extends Model
{
    /**
     * @var string $table
     */
    protected string $table = 'channels';

    /**
     * @var array|string[]
     */
    protected array $fillable = [
        'owner_id',
        'title',
        'description',
        'name',
    ];

    /**
     * @return BelongsTo
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo('users', 'id', 'owner_id');
    }

    /**
     * @return HasMany
     */
    public function videos(): HasMany
    {
        return $this->hasMany('videos', 'channel_id', 'id');
    }
}
