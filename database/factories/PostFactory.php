<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->sentence();

        return [
            'title' => $title,
            'user_id' => User::inRandomOrder()->first() ?? User::factory()->create(),
            'category_id' => Category::inRandomOrder()->first() ?? Category::factory()->create(),
            'slug' => Str::slug($title),
            //'content' => $this->faker->paragraphs(nb:7, asText: true), // PHP8, Named arguments
            'content' => '<p>' . implode('</p><p>', $this->faker->paragraphs(6)) . '</p>',
            'published_at' => $this->faker->optional(weight:0.7)->passthrough( now() ), // 70% chance to $now
        ];
    }
}
