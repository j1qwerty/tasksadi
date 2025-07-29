<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    private function checkAdminAccess()
    {
        if (!Auth::user() || !Auth::user()->isAdmin()) {
            return false;
        }
        return true;
    }

    public function getStats()
    {
        if (!$this->checkAdminAccess()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        $totalUsers = User::count();
        $totalTasks = Task::count();
        $inProgressTasks = Task::where('status', 'in_progress')->count();
        $completedTasks = Task::where('status', 'completed')->count();

        return response()->json([
            'total_users' => $totalUsers,
            'total_tasks' => $totalTasks,
            'in_progress_tasks' => $inProgressTasks,
            'completed_tasks' => $completedTasks,
        ]);
    }

    public function getUsers()
    {
        if (!$this->checkAdminAccess()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        $users = User::orderBy('created_at', 'desc')->get();
        return response()->json($users);
    }

    public function getTasks()
    {
        if (!$this->checkAdminAccess()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        $tasks = Task::with('user')->orderBy('created_at', 'desc')->get();
        return response()->json($tasks);
    }

    public function createTask(Request $request)
    {
        if (!$this->checkAdminAccess()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:pending,in_progress,completed',
            'assigned_to' => 'required|exists:users,id',
        ]);

        $task = Task::create($request->all());

        return response()->json([
            'success' => true,
            'task' => $task->load('user'),
            'message' => 'Task created successfully'
        ]);
    }

    public function updateTask(Request $request, $taskId)
    {
        if (!$this->checkAdminAccess()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:pending,in_progress,completed',
            'assigned_to' => 'required|exists:users,id',
        ]);

        $task = Task::findOrFail($taskId);
        $task->update($request->all());

        return response()->json([
            'success' => true,
            'task' => $task->load('user'),
            'message' => 'Task updated successfully'
        ]);
    }

    public function deleteTask($taskId)
    {
        if (!$this->checkAdminAccess()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        $task = Task::findOrFail($taskId);
        $task->delete();

        return response()->json([
            'success' => true,
            'message' => 'Task deleted successfully'
        ]);
    }

    public function updateUserRole(Request $request, $userId)
    {
        if (!$this->checkAdminAccess()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        $request->validate([
            'role' => 'required|in:admin,user',
        ]);

        $user = User::findOrFail($userId);
        $user->update(['role' => $request->role]);

        return response()->json([
            'success' => true,
            'user' => $user,
            'message' => 'User role updated successfully'
        ]);
    }
}
