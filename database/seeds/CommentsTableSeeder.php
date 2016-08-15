<?php

use Illuminate\Database\Seeder;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $posts = App\Post::get();
        App\Comment::truncate();

        $posts->each(function ($post) {
            $post->comments()->save(
                factory(App\Comment::class)->make()
            );
        });
    }
}
