<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Suhaib',
            'email' => 'suhaib@gmail.com',
            'password' => Hash::make('0592679732j'),
            'role' => 'Admin',
        ]);

        User::create([
            'name' => 'Mohammad',
            'email' => 'Mohammad@gmail.com',
            'password' => Hash::make('Mohammad'),
            'role' => 'Admin',
        ]);

        User::create([
            'name' => 'Ahmed',
            'email' => 'ahmed@gmail.com',
            'password' => Hash::make('0592679732j'),
            'role' => 'Employee',
        ]);
        User::create([
            'name' => 'Ali',
            'email' => 'Ali@gmail.com',
            'password' => Hash::make('0592679732j'),
            'role' => 'Employee',
        ]);
    }
}
