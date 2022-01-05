<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithPagination;

class Posts extends Component
{
    use WithPagination;

    public $category;

    protected $queryString = ['category'];

    public function render()
    {
        $posts = Post::query()
            ->published()
            ->when(!!$this->category, function ($query) {
                $query->whereHas('category', function ($query) {
                    $query->where('name', 'like', $this->category);
                });
            })
            ->orderByDesc('published_at')
            ->paginate(9);

        return view('livewire.posts', [
            'posts' => $posts,
        ]);
    }
}
