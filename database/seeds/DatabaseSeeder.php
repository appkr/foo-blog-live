<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->setUp();

        // tags table
        App\Tag::truncate();
        foreach (config('project.tags') as $tag) {
            App\Tag::create([
                'name' => $tag,
                'slug' => str_slug($tag),
            ]);
        }
        $this->command->info('tags table seeded');

        if (! app()->environment('production')) {
            $this->runDevSeed();
        }

        $this->tearDown();
    }

    private function setUp()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
    }

    private function tearDown()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }

    private function runDevSeed()
    {
        // users table
        $this->call(UsersTableSeeder::class);

        $users = App\User::get();

        // posts table
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
        $this->command->info('tags table seeded');

        // comments table
        App\Comment::truncate();
        $posts->each(function ($post) {
            $post->comments()->save(
                factory(App\Comment::class)->make()
            );
        });
        $this->command->info('comments table seeded');
    }
}
