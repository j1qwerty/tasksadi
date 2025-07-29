<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Task;
use App\Models\User;

class TasksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $userEmails = ['user1@tasks.com', 'user2@tasks.com', 'user3@tasks.com'];
        
        Task::create([
            'title' => 'Task 1',
            'description' => 'Description for task 1',
            'status' => 'completed',
            'assigned_to' => $users->where('email', $userEmails[array_rand($userEmails)])->first()->id,
        ]);

        Task::create([
            'title' => 'Task 2',
            'description' => 'Description for task 2',
            'status' => 'in_progress',
            'assigned_to' => $users->where('email', $userEmails[array_rand($userEmails)])->first()->id,
        ]);

        Task::create([
            'title' => 'Task 3',
            'description' => 'Description for task 3',
            'status' => 'pending',
            'assigned_to' => $users->where('email', $userEmails[array_rand($userEmails)])->first()->id,
        ]);

        Task::create([
            'title' => 'Task 4',
            'description' => 'Description for task 4',
            'status' => 'pending',
            'assigned_to' => $users->where('email', $userEmails[array_rand($userEmails)])->first()->id,
        ]);

        Task::create([
            'title' => 'Task 5',
            'description' => 'Description for task 5',
            'status' => 'pending',
            'assigned_to' => $users->where('email', $userEmails[array_rand($userEmails)])->first()->id,
        ]);

        // Additional tasks
        Task::create([
            'title' => 'Task 6',
            'description' => 'Description for task 6',
            'status' => 'in_progress',
            'assigned_to' => $users->where('email', $userEmails[array_rand($userEmails)])->first()->id,
        ]);

        Task::create([
            'title' => 'Task 7',
            'description' => 'Description for task 7',
            'status' => 'completed',
            'assigned_to' => $users->where('email', $userEmails[array_rand($userEmails)])->first()->id,
        ]);
    }
}