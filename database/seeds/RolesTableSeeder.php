<?php

use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::firstOrCreate(
            ['name' => 'administrator'],
            ['display_name' => 'Administrator', 'description' => 'Ini adalah administrator']
        );

        Role::firstOrCreate(
            ['name' => 'seller'],
            ['display_name' => 'Seller', 'description' => 'Ini adalah penjual']
        );

        Role::firstOrCreate(
            ['name' => 'member'],
            ['display_name' => 'Member', 'description' => 'Ini adalah member']
        );
    }
}
