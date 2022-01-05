<?php

namespace App\Models;

use App\Helpers\Status;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'published_at' => 'datetime',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['user_id', 'category_id', 'title', 'slug', 'thumbnail', 'content'];

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['category', 'author'];



    /**
     * Local Scopes
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('published_at', '<', now());
    }



    /**
     * Custom accessors
     *
     * https://www.youtube.com/watch?v=P3J4wVSlKnQ (new way)
     */
    protected $appends = ['excerpt', 'thumbnail_url', 'status', 'published_at_for_editing'];

    /** Post excerpt */
    protected function excerpt(): Attribute
    {
        return new Attribute(
            get: fn() => Str::limit( strip_tags($this->content), 200)
        );
    }

    /** Post thumbnail url */
    protected function thumbnailUrl(): Attribute
    {
        return new Attribute(
            get: fn() => $this->thumbnail
                ? Storage::disk('thumbnails')->url("/{$this->user_id}/{$this->thumbnail}")
                : Storage::disk('thumbnails')->url('default-thumbnail.jpg')
        );
    }

    /** Statuses */
    public function getStatusAttribute(): string
    {
        return Status::get($this);
    }

    /** published_at_for_display for display */
    protected function publishedAtForDisplay(): Attribute
    {
        return new Attribute(
            get: fn() => $this->published_at?->toDateTimeString()
        );
    }

    /** get published_at_for_editing */
    public function getPublishedAtForEditingAttribute()
    {
        return $this->published_at?->toDateTimeString();
    }

    public function setPublishedAtForEditingAttribute($value)
    {
        if ( empty($value) ){
            $this->published_at = null;
        } else {

            try {
                $this->published_at = Carbon::parse($value);
            } catch ( \Exception $e) {
                $this->published_at = now();
            }

        }
    }

    /**
     * Relationships
     */
    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function author(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->user();
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
