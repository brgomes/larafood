<?php

use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlansTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Plan::create([
            'name' => 'Plano Básico',
            'url' => 'plano-basico',
            'price' => 19.9,
            'description' => 'Basicão',
        ]);
    }
}
