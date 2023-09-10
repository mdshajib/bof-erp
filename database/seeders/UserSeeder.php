<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'first_name'        => 'Manjurul',
                'last_name'         => 'Hasan',
                'email'             => 'shajib@gmail.com',
                'password'          => bcrypt('123456'),
                'role'              => 'admin',
                'lang'              => 'en',
                'outlet_id'         => 1
            ], [
                'first_name'        => 'Farhan',
                'last_name'         => 'Sikder',
                'email'             => 'farhan@gmail.com',
                'password'          => bcrypt('123456'),
                'role'              => 'admin',
                'lang'              => 'en',
                'outlet_id'         => 1
            ]
        ];

        foreach ( $users as $user ) {
            $user = User::updateOrCreate(['email' => $user['email']], $user );
            $user->assignRole($user['role']);
        }
    }
}
