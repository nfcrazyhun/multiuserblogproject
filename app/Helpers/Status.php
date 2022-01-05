<?php

namespace App\Helpers;

use ReflectionClass;

abstract class Status
{
    public const DRAFT = 'draft';
    public const PENDING = 'pending';
    public const PUBLISHED = 'published';
    public const ARCHIVED = 'archived';
    public const UNKNOWN = 'unknown';

    public static function get($post): string
    {
        // PHP8 match expression
        $status = match(true) {
            isset($post->deleted_at) => Status::ARCHIVED,
            !isset($post->published_at) => Status::DRAFT,
            $post->published_at->isFuture() => Status::PENDING,
            $post->published_at->isPast() => Status::PUBLISHED,
            'default' => Status::UNKNOWN
        };

        return $status;
    }

    public static function getSelectDropDownFilterOptions(): \Illuminate\Support\Collection
    {
        $refl = new ReflectionClass(Status::class);
        $statuses = collect($refl->getConstants());

        $keys = $statuses->values()->all();
        $values = $statuses->values()->map(function ($item) {
            return ucfirst($item);
        })->all();

        $statuses = array_combine($keys, $values);
        $statuses = collect($statuses)->prepend(value:'All',key:'');

        return $statuses;
    }
}
