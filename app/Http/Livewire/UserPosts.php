<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class UserPosts extends Posts
{
    // Livewire Route model binding
    // https://www.youtube.com/watch?v=4Tk_2YULX4s
    public User $user;

    public function render() //overrides
    {
        $posts = $this->user->posts()
            ->published()
            ->when(!!$this->category, function ($query) {
                $query->whereHas('category', function ($query) {
                    $query->where('name', 'like', $this->category);
                });
            })
            ->orderByDesc('published_at')
            ->paginate(9);

        return view('livewire.user-posts', [
            'posts' => $posts,
        ]);
    }


}
