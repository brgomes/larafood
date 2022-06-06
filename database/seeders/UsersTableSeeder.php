<?php

namespace Databases\Seeders;

use App\Models\Tenant;
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
        $tenant = Tenant::first();

        $tenant->users()->create([
            'name' => 'Bruno R. Gomes',
            'email' => 'bruno@opecsis.com.br',
            'password' => bcrypt('12345678'),
        ]);
    }
}
