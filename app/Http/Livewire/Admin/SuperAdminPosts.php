<?php

namespace App\Http\Livewire\Admin;

use App\Helpers\CollectionHelper;
use App\Models\Post;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class SuperAdminPosts extends IndexPosts
{
    public $showFilters = true;

    protected function source()
    {
        return Post::query();
    }

    public function render()
    {
        return parent::render();
    }


}
