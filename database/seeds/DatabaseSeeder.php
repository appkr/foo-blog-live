<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    private $sqlite = false;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->setUp();

        $this->call(TagsTableSeeder::class);

        if (! app()->environment('production')) {
            $this->runDevSeed();
        }

        $this->tearDown();
    }

    private function setUp()
    {
        if (config('database.default') == 'sqlite') {
            $this->sqlite = true;
        } else {
            DB::statement('SET FOREIGN_KEY_CHECKS=0');
        }
    }

    private function tearDown()
    {
        if (! $this->sqlite) {
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
        }
    }

    private function runDevSeed()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(PostsTableSeeder::class);
        $this->call(CommentsTableSeeder::class);
    }
}
