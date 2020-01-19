<?php

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (User::where('email', 'administrator')->first() === null) {
            $user               = new User();
            $user->name         = 'Administrator';
            $user->email        = 'administrator@gmail.com';
            $user->password     = Hash::make('password');
            $user->save();

            // role attach alias
            $role = Role::where('name', 'administrator')->first();
            $user->attachRole($role);
        }
    }
}
