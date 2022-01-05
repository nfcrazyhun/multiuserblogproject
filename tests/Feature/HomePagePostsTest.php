<?php

namespace Tests\Feature;


use App\Http\Livewire\Posts;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Livewire\Livewire;
use Tests\TestCase;

class HomePagePostsTest extends TestCase
{
    public function test_can_see_livewire_posts_component_on_home_page()
    {
        $this->get('/')
            ->assertSuccessful()
            ->assertSeeLivewire('posts');
    }

    public function test_can_see_posts()
    {
        Livewire::test(Posts::class)
            ->assertContainsBladeComponent('posts.grid')
        ;

        //Memo: Cannot test properly, because Livewire::test unfortunately does not see properly into nested blade components. :(
    }
}
