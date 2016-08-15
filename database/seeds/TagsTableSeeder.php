<?php

use Illuminate\Database\Seeder;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Tag::truncate();
        foreach (config('project.tags') as $tag) {
            App\Tag::create([
                'name' => $tag,
                'slug' => str_slug($tag),
            ]);
        }
    }
}
