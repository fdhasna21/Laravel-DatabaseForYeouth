<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(5)->create();
        DB::table('users')->insert([
            'name' => 'Nda',
            'email' => 'fdh@gmail.com',
            'password' => Hash::make('admin'),
            'created_at' => now()
        ]);
    }
}
