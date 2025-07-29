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
        
        Task::create([
            'title' => 'Setup Development Environment',
            'description' => 'Install and configure all necessary development tools and frameworks for the project.',
            'status' => 'completed',
            'assigned_to' => $users->where('email', 'john@tasks.com')->first()->id,
        ]);

        Task::create([
            'title' => 'Design Database Schema',
            'description' => 'Create the database schema design including all tables, relationships, and constraints.',
            'status' => 'in_progress',
            'assigned_to' => $users->where('email', 'jane@tasks.com')->first()->id,
        ]);

        Task::create([
            'title' => 'Implement User Authentication',
            'description' => 'Integrate Firebase authentication system with the Laravel backend.',
            'status' => 'pending',
            'assigned_to' => $users->where('email', 'john@tasks.com')->first()->id,
        ]);

        Task::create([
            'title' => 'Create Task Management UI',
            'description' => 'Build responsive user interface for task creation, editing, and management.',
            'status' => 'pending',
            'assigned_to' => $users->where('email', 'jane@tasks.com')->first()->id,
        ]);

        Task::create([
            'title' => 'Write API Documentation',
            'description' => 'Document all API endpoints with examples and usage instructions.',
            'status' => 'pending',
            'assigned_to' => $users->where('email', 'john@tasks.com')->first()->id,
        ]);
    }
}
