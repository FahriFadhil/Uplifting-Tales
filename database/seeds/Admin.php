<?php

use App\User;
use Illuminate\Database\Seeder;

class Admin extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => env('ADMIN_NAME'),
            'slug' => env('ADMIN_SLUG'),
            'email' => env('ADMIN_EMAIL'),
            'password' => bcrypt(env('ADMIN_PASSWORD')),
            'authorization' => 'admin',
            'bio' => 'Hi im Fahri the developer of this site. Im really enjoying making this project and having more experience by doing it. I know there\'s still so many things i need to work on but i\'ve try my best. Hope you guys can enjoy the stories provided by this sites and can contribute to share your own stories. Enjoy!',
        ]);
    }
}
