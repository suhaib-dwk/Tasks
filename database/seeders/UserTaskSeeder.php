<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserTaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::where('role', 'Employee')->get();
        $tasks = Task::all();

        foreach ($users as $user) {
            $user->tasks()->attach(
                $tasks->random(rand(1, 3))->pluck('id')->toArray()
            );
        }
    }
}
