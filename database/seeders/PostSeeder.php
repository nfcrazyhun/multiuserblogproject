<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (User::all() as $user) {
            Post::factory()->count( rand(2,4) )->create( ['user_id' => $user->id] );
        }

        //example html data
$markdown = "
<h1>Heading 1</h1>
<h2>Heading 2</h2>
<h3>Heading 3</h3>
<h4>Heading 4</h4>
<h5>Heading 5</h5>
<h6>Heading 6</h6>

<h3>An Unordered HTML List</h3>
<ul>
<li>Coffee</li>
<li>Tea</li>
<li>Milk</li>
</ul>

<h3>An Ordered HTML List</h3>
<ol>
<li>Coffee</li>
<li>Tea</li>
<li>Milk</li>
</ol>

<blockquote>
For 50 years, WWF has been protecting the future of nature.  The
world's leading conservation organization,  WWF works in 100 countries
and is supported by  1.2 million members in the United States and
close to 5 million globally.
</blockquote>
";
        Post::factory()->create(['user_id' => 1, 'content' => $markdown, 'published_at' => now()->addSeconds(2) ]);
    }
}
