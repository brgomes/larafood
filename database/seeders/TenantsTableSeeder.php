<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;

class TenantsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $plan = Plan::first();

        $plan->tenants()->create([
            'cnpj' => '23882706000120',
            'name' => 'OPECsis',
            'url' => 'opecsis',
            'email' => 'contato@opecsis.com.br',
        ]);
    }
}
