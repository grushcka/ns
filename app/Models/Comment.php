<?php

namespace NS\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * Class Comment
 * Comment to video or another comment
 * @package NS\Models
 * @property User $owner
 * @property Video $video
 * @property Comment $parentComment
 * @property Collection $comments
 * @property string $text
 */
class Comment extends Model
{
    /**
     * @var string $table
     */
    protected string $table = 'comments';


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
    public function video(): BelongsTo
    {
        return $this->belongsTo('videos', 'id', 'video_id');
    }

    /**
     * @return BelongsTo
     */
    public function parentComment(): BelongsTo
    {
        return $this->belongsTo('comments', 'id', 'parent_id');
    }

    /**
     * @return HasMany
     */
    public function comments(): HasMany
    {
        return $this->hasMany('comments', 'id', 'parent_id');
    }
}
