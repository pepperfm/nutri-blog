<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        \App\Models\User::factory(10)->create();
        app('db')->table('roles')->insert([
            ['name' => 'doctor'],
            ['name' => 'client'],
        ]);
        // $this->call('UsersTableSeeder');
    }
}
