<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(['username' => 'CoreAdmin', 
                        'email' => 'admin@melonseed.com', 
                        'avatar' => '/img/avatars/default.jpg', 
                        'password' => '$2y$10$0oJ08el8vT6KWSdlNn1LXujGohivz0RBq3dbEIuIAF8DaoGyxEPXO', 
                        'is_provider' => '1', 
                        'role' => '1', 
                        'slug' => 'blade slug', 
                        'register_ip' => '127.0.0.1', 
                        'login_ip' => '127.0.0.1', 
                    ]);
        DB::table('users')->insert(['username' => 'Blade', 
                        'email' => 'tech.blade@hotmail.com', 
                        'avatar' => '/img/avatars/default.jpg', 
                        'password' => '$2y$10$0oJ08el8vT6KWSdlNn1LXujGohivz0RBq3dbEIuIAF8DaoGyxEPXO', 
                        'is_provider' => '1', 
                        'slug' => 'blade slug', 
                        'register_ip' => '127.0.0.1', 
                        'login_ip' => '127.0.0.1', 
                    ]);
    }
}
