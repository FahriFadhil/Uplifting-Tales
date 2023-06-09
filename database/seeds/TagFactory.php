<?php

use App\Tag;
use Illuminate\Database\Seeder;

class TagFactory extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tag::insert([
                [
                    'body' => 'Inspiration',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'body' => 'Heartwarming',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'body' => 'Courage',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'body' => 'Appreciation',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'body' => 'Journey of life',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'body' => 'Recovery',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'body' => 'Success',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'body' => 'Kindness',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'body' => 'Spirit',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'body' => 'Empowerment',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
        ]);
    }
}
