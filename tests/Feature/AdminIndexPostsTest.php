<?php

namespace Tests\Feature;

use App\Http\Livewire\Admin\IndexPosts;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class AdminIndexPostsTest extends TestCase
{
    /*
     * Livewire Testing
     * https://laravel-livewire.com/docs/2.x/testing
     */

/**
|--------------------------------------------------------------------------
| Happy Path
|--------------------------------------------------------------------------
 */

    public function test_can_see_livewire_index_posts_component_on_admin_posts()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/admin/posts')
            ->assertSuccessful()
            ->assertSeeLivewire('admin.index-posts');
    }

    public function test_admin_index_posts_datatable_is_populated()
    {
        $user = User::factory()->create();

        $post1 = Post::factory()->for($user)->create(['published_at' => now()]);
        $post2 = Post::factory()->for($user)->create(['published_at' => null]);

        Livewire::actingAs($user)
            ->test(IndexPosts::class)
            ->assertSee([
                $post1->id,
                $post1->title,
                $post1->category->name,
                $post1->status,
                $post1->created_at,
                $post1->published_at,
            ])
            ->assertSee([
                $post2->id,
                $post2->title,
                $post2->category->name,
                $post2->status,
                $post2->created_at,
                $post2->published_at,
            ])
        ;
    }

/**
|--------------------------------------------------------------------------
| Column sorting test
|--------------------------------------------------------------------------
 */

/*
|------------------ id --------------------------------------------------------
*/
    public function test_admin_index_posts_datatable_column_id_sorted_asc()
    {
        $user = User::factory()->create();

        $post1 = Post::factory()->for($user)->create(['id' => '567']);
        $post2 = Post::factory()->for($user)->create(['id' => '1044']);

        Livewire::actingAs($user)
            ->test(IndexPosts::class)
            ->set('sortField', 'id')
            ->set('sortDirection', 'asc')
            ->assertSeeInOrder([$post1->id, $post2->id]);
    }

    public function test_admin_index_posts_datatable_column_id_sorted_desc()
    {
        $user = User::factory()->create();

        $post1 = Post::factory()->for($user)->create(['id' => '567']);
        $post2 = Post::factory()->for($user)->create(['id' => '1044']);

        Livewire::actingAs($user)
            ->test(IndexPosts::class)
            ->set('sortField', 'id')
            ->set('sortDirection', 'desc')
            ->assertSeeInOrder([$post2->id, $post1->id]);
    }

/*
|------------------ Title --------------------------------------------------------
*/
    public function test_admin_index_posts_datatable_column_title_sorted_asc()
    {
        $user = User::factory()->create();

        $post1 = Post::factory()->for($user)->create(['title' => 'bar']);
        $post2 = Post::factory()->for($user)->create(['title' => 'foo']);

        Livewire::actingAs($user)
            ->test(IndexPosts::class)
            ->set('sortField', 'title')
            ->set('sortDirection', 'asc')
            ->assertSeeInOrder([$post1->title, $post2->title]);
    }

    public function test_admin_index_posts_datatable_column_title_sorted_desc()
    {
        $user = User::factory()->create();

        $post1 = Post::factory()->for($user)->create(['title' => 'bar']);
        $post2 = Post::factory()->for($user)->create(['title' => 'foo']);

        Livewire::actingAs($user)
            ->test(IndexPosts::class)
            ->set('sortField', 'title')
            ->set('sortDirection', 'desc')
            ->assertSeeInOrder([$post2->title, $post1->title]);
    }

/*
|------------------ Title --------------------------------------------------------
*/
    public function test_admin_index_posts_datatable_column_category_sorted_asc()
    {
        $user = User::factory()->create();

        $category1 = Category::factory()->create(['name' => 'apple']);
        $category2 = Category::factory()->create(['name' => 'banana']);

        $post1 = Post::factory()->for($user)->create(['category_id' => $category1->id]);
        $post2 = Post::factory()->for($user)->create(['category_id' => $category2->id]);

        Livewire::actingAs($user)
            ->test(IndexPosts::class)
            ->set('sortField', 'categories.name')
            ->set('sortDirection', 'asc')
            ->assertSeeInOrder([$post1->category->name, $post2->category->name]);
    }

    public function test_admin_index_posts_datatable_column_category_sorted_desc()
    {
        $user = User::factory()->create();

        $category1 = Category::factory()->create(['name' => 'apple']);
        $category2 = Category::factory()->create(['name' => 'banana']);

        $post1 = Post::factory()->for($user)->create(['category_id' => $category1->id]);
        $post2 = Post::factory()->for($user)->create(['category_id' => $category2->id]);

        Livewire::actingAs($user)
            ->test(IndexPosts::class)
            ->set('sortField', 'categories.name')
            ->set('sortDirection', 'desc')
            ->assertSeeInOrder([$post2->category->name, $post1->category->name]);
    }
/*
|------------------ Created at --------------------------------------------------------
*/
    public function test_admin_index_posts_datatable_column_created_at_sorted_asc()
    {
        $user = User::factory()->create();

        $post1 = Post::factory()->for($user)->create(['created_at' => now()->subMinute()]);
        $post2 = Post::factory()->for($user)->create(['created_at' => now()->addMinute()]);

        Livewire::actingAs($user)
            ->test(IndexPosts::class)
            ->set('sortField', 'created_at')
            ->set('sortDirection', 'asc')
            ->assertSeeInOrder([$post1->created_at, $post2->created_at]);
    }

    public function test_admin_index_posts_datatable_column_created_at_sorted_desc()
    {
        $user = User::factory()->create();

        $post1 = Post::factory()->for($user)->create(['created_at' => now()->subMinute()]);
        $post2 = Post::factory()->for($user)->create(['created_at' => now()->addMinute()]);

        Livewire::actingAs($user)
            ->test(IndexPosts::class)
            ->set('sortField', 'created_at')
            ->set('sortDirection', 'desc')
            ->assertSeeInOrder([$post2->created_at, $post1->created_at]);
    }

/*
|------------------ Published at --------------------------------------------------------
*/
    public function test_admin_index_posts_datatable_column_published_at_sorted_asc()
    {
        $user = User::factory()->create();

        $post1 = Post::factory()->for($user)->create(['published_at' => now()->subMinute()]);
        $post2 = Post::factory()->for($user)->create(['published_at' => now()->addMinute()]);

        Livewire::actingAs($user)
            ->test(IndexPosts::class)
            ->set('sortField', 'published_at')
            ->set('sortDirection', 'asc')
            ->assertSeeInOrder([$post1->published_at_for_display, $post2->published_at_for_display]);
    }

    public function test_admin_index_posts_datatable_column_published_at_sorted_desc()
    {
        $user = User::factory()->create();

        $post1 = Post::factory()->for($user)->create(['published_at' => now()->subMinute()]);
        $post2 = Post::factory()->for($user)->create(['published_at' => now()->addMinute()]);

        Livewire::actingAs($user)
            ->test(IndexPosts::class)
            ->set('sortField', 'published_at')
            ->set('sortDirection', 'desc')
            ->assertSeeInOrder([$post2->published_at_for_display, $post1->published_at_for_display]);
    }

/**
|--------------------------------------------------------------------------
| Multi user tests
|--------------------------------------------------------------------------
 */
    public function test_admin_index_posts_datatable_current_user_only_see_his_own_posts()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $post1 = Post::factory()->for($user1)->create();
        $post2 = Post::factory()->for($user2)->create();

        Livewire::actingAs($user1)
            ->test(IndexPosts::class)
            ->assertSee($post1->title)
            ->assertDontSee($post2->title);
    }

/**
|--------------------------------------------------------------------------
| Pagination tests
|--------------------------------------------------------------------------
*/

    public function test_admin_index_posts_datatable_pagination_works()
    {
        $user = User::factory()->create();

        $posts = Post::factory()->count( (new IndexPosts())->pageSize + 1 )->for($user)->create();

        Livewire::actingAs($user)
            ->test(IndexPosts::class)
            ->set('sortField', 'id')
            ->set('sortDirection', 'asc')
            ->assertSee($posts->first()->title)
            ->assertDontSee($posts->last()->title)
            ->set('sortDirection', 'desc')
            ->assertSee($posts->last()->title)
            ->assertDontSee($posts->first()->title);
    }

/**
|--------------------------------------------------------------------------
| Delete tests
|--------------------------------------------------------------------------
*/

    public function test_admin_index_posts_can_delete_post()
    {
        $user = User::factory()->create();

        $post = Post::factory()->for($user)->create();

        $this->assertNotSoftDeleted($post);

        Livewire::actingAs($user)
            ->test(IndexPosts::class)
            ->call('edit',$post->id) //set 'editing' property
            ->call('delete');

        $this->assertSoftDeleted($post);
    }

    public function test_admin_index_posts_cannot_delete_other_users_post()
    {
        $user = User::factory()->create();
        $user2 = User::factory()->create();

        $post = Post::factory()->for($user2)->create();

        $this->assertNotSoftDeleted($post);

        Livewire::actingAs($user)
            ->test(IndexPosts::class)
            ->call('edit',$post->id) //set 'editing' property
            ->call('delete');

        $this->assertNotSoftDeleted($post);
    }

/**
|--------------------------------------------------------------------------
| Restore tests
|--------------------------------------------------------------------------
*/

    public function test_admin_index_posts_can_restore_post()
    {
        $user = User::factory()->create();

        $post = Post::factory()->for($user)->create(['deleted_at' => now()]);

        $this->assertSoftDeleted($post);

        Livewire::actingAs($user)
            ->test(IndexPosts::class)
            ->call('edit',$post->id) //set 'editing' property
            ->call('restore');

        $this->assertNotSoftDeleted($post);
    }

    public function test_admin_index_posts_cannot_restore_other_users_post()
    {
        $user = User::factory()->create();
        $user2 = User::factory()->create();

        $post = Post::factory()->for($user2)->create(['deleted_at' => now()]);

        $this->assertSoftDeleted($post);

        Livewire::actingAs($user)
            ->test(IndexPosts::class)
            ->call('edit',$post->id) //set 'editing' property
            ->call('delete');

        $this->assertSoftDeleted($post);
    }

/**
|--------------------------------------------------------------------------
| Post create tests
|--------------------------------------------------------------------------
*/

    public function test_can_create_post()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $now = now()->toDateTimeString();

        Livewire::actingAs($user)
            ->test(IndexPosts::class)
            ->set('editing.title', 'test post')
            ->set('editing.slug', 'test-slug')
            ->set('editing.content', 'test-content')
            ->set('editing.category_id', $category->id)
            ->set('editing.published_at_for_editing', $now)
            ->call('save');

        $this->assertDatabaseHas('posts', [
            'title' => 'test post',
            'slug' => 'test-slug',
            'content' => 'test-content',
            'category_id' => $category->id,
            'published_at' => $now,
        ]);
    }

    public function test_can_create_post_with_thumbnail()
    {
        Storage::fake('thumbnails');

        $user = User::factory()->create();
        $post = Post::factory()->make();
        $file = UploadedFile::fake()->image('avatar.png');

        Livewire::actingAs($user)
            ->test(IndexPosts::class)
            ->set('editing.title', $post->title)
            ->set('editing.slug', $post->slug)
            ->set('editing.content', $post->content)
            ->set('editing.category_id', $post->category_id)
            ->set('editing.published_at_for_editing', $post->published_at)
            ->set('upload', $file)
            ->call('save');

        $postFromDb = Post::where($post->getAttributes())->first();

        $this->assertDatabaseHas('posts', $post->getAttributes());
        Storage::disk('thumbnails')->assertExists($postFromDb->user_id.'/'.$postFromDb->thumbnail);
    }

/**
|--------------------------------------------------------------------------
| Post create Validation Test
|--------------------------------------------------------------------------
*/

/*
|------------------ title --------------------------------------------------------
*/
    public function test_title_required()
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(IndexPosts::class)
            ->set('editing.title', '')
            ->call('save')
            ->assertHasErrors(['editing.title' => 'required']);

        $this->assertEquals(0, Post::count());
    }

    public function test_title_max_255_characters()
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(IndexPosts::class)
            ->set('editing.title', str_repeat('a',256))
            ->call('save')
            ->assertHasErrors(['editing.title' => 'max']);
    }

/*
|------------------ slug --------------------------------------------------------
*/
    public function test_slug_required()
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(IndexPosts::class)
            ->set('editing.slug', '')
            ->call('save')
            ->assertHasErrors(['editing.slug' => 'required']);
    }

    public function test_title_slug__max_255_characters()
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(IndexPosts::class)
            ->set('editing.slug', str_repeat('a',256))
            ->call('save')
            ->assertHasErrors(['editing.slug' => 'max']);
    }

    public function test_title_slug_must_be_unique()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();

        Livewire::actingAs($user)
            ->test(IndexPosts::class)
            ->set('editing.slug', $post->slug)
            ->call('save')
            ->assertHasErrors(['editing.slug' => 'unique']);
    }

    public function test_title_slug_two_different_users_post_can_have_same_slug()
    {
        $user = User::factory()->create();
        $user2 = User::factory()->create();

        $post = Post::factory()->create(['user_id' => $user2, 'slug' => 'it-can-be-same']);

        Livewire::actingAs($user)
            ->test(IndexPosts::class)
            ->set('editing.slug', $post->slug)
            ->call('save')
            ->assertHasNoErrors(['editing.slug' => 'unique']);
    }

/*
|------------------ content --------------------------------------------------------
*/
    public function test_content_required()
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(IndexPosts::class)
            ->set('editing.content', '')
            ->call('save')
            ->assertHasErrors(['editing.content' => 'required']);
    }

    public function test_content_max_10240_characters()
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(IndexPosts::class)
            ->set('editing.content', str_repeat('a',10241))
            ->call('save')
            ->assertHasErrors(['editing.content' => 'max']);
    }

/*
|------------------ content --------------------------------------------------------
*/
    public function test_category_id_required()
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(IndexPosts::class)
            ->set('editing.category_id', '')
            ->call('save')
            ->assertHasErrors(['editing.category_id' => 'required']);
    }

    public function test_category_id_must_be_existing_category()
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(IndexPosts::class)
            ->set('editing.category_id', 'asd')
            ->call('save')
            ->assertHasErrors(['editing.category_id' => 'exists']);
    }

/*
|------------------ published_at --------------------------------------------------------
*/
    public function test_published_at_not_required()
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(IndexPosts::class)
            ->set('editing.published_at_for_editing', '')
            ->call('save')
            ->assertHasNoErrors(['editing.published_at_for_editing']);
    }

/**
|--------------------------------------------------------------------------
| Post edit Validation Test
|--------------------------------------------------------------------------
*/
    public function test_edit_post_is_pre_populated()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user]);

        Livewire::actingAs($user)
            ->test(IndexPosts::class)
            ->call('edit',$post->id)
            ->assertSet('editing.title', $post->title)
            ->assertSet('editing.slug', $post->slug)
            ->assertSet('editing.slug', $post->slug)
            ->assertSeeHtml($post->thumbnail_url)
            ->assertSet('editing.content',$post->content)
            ->assertSet('editing.category_id',$post->category_id)
            ->assertSet('editing.published_at_for_editing',$post->published_at_for_editing)
            ;
    }

    public function test_can_edit_post_with_thumbnail()
    {
        Storage::fake('thumbnails');

        $user = User::factory()->create();
        $originalPost = Post::factory()->create();

        $post = Post::factory()->make();
        $file = UploadedFile::fake()->image('avatar.png');

        Livewire::actingAs($user)
            ->test(IndexPosts::class)
            ->call('edit', $originalPost->id)
            ->set('editing.title', $post->title)
            ->set('editing.slug', $post->slug)
            ->set('editing.content', $post->content)
            ->set('editing.category_id', $post->category_id)
            ->set('editing.published_at_for_editing', $post->published_at)
            ->set('upload', $file)
            ->call('save');

        $postFromDb = Post::where($post->getAttributes())->first();

        $this->assertDatabaseMissing('posts', $originalPost->getAttributes());
        $this->assertDatabaseHas('posts', $post->getAttributes());
        Storage::disk('thumbnails')->assertExists($postFromDb->user_id.'/'.$postFromDb->thumbnail);
    }

/**
|--------------------------------------------------------------------------
| Hack the session Test
|
| * Changes in user_id does not possible normally.
| * But it can be changes through "Livewire devtools", which is usually disabled in production.
|--------------------------------------------------------------------------
*/
    public function test_user_id_must_be_exists()
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(IndexPosts::class)
            ->set('editing.user_id', 'asd')
            ->call('save')
            ->assertHasErrors(['editing.user_id' => 'exists']);
    }

    public function test_user_id_must_be_current_user_id()
    {
        $user = User::factory()->create();
        $user2 = User::factory()->create();

        Livewire::actingAs($user)
            ->test(IndexPosts::class)
            ->set('editing.user_id', $user2->id)
            ->call('save')
            ->assertHasErrors(['editing.user_id' => 'in']);
    }

}
