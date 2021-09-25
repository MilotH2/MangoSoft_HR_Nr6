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
        // $this->call(UsersTableSeeder::class);
        \Illuminate\Support\Facades\DB::table('users')->insert([
            'firstname'                              => 'Owner',
            'lastname'                               => 'Admin',
            'profile_picture'                               => 'default.png',
            'position'                               => 'owner',
            'role'                               => '1',
            'email'                             => 'owner@admin.com',
            'password'                          => bcrypt('password'),
        ]);
    }
}
