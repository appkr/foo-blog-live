<?php

use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = App\User::get();
        App\Post::truncate();

        $users->each(function ($user) {
            $user->posts()->save(factory(App\Post::class)->make());
            $user->posts()->save(factory(App\Post::class)->make());
        });

        $faker = Faker\Factory::create();
        $posts = App\Post::get();
        $tagIds = App\Tag::pluck('id')->toArray();

        // attach tags
        DB::table('post_tag')->truncate();
        foreach ($posts as $post) {
            $post->tags()->sync(
                $faker->randomElements($tagIds, rand(1, 2))
            );
        }
    }
}
