<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(TagFactory::class);
        $this->call(Admin::class);
        $this->call(StoryFactory::class);
    }
}
