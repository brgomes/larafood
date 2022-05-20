<?php

use App\Models\User;
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
        User::create([
            'name' => 'Bruno R. Gomes',
            'email' => 'bruno@brgomes.com',
            'password' => bcrypt('12345678'),
        ]);
    }
}
