<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function userDashboard()
    {
        return view('dashboard.user');
    }

    public function adminDashboard()
    {
        if (!Auth::user()->isAdmin()) {
            return redirect('/dashboard');
        }
        
        return view('dashboard.admin');
    }

    public function getUserTasks(Request $request)
    {
        $user = Auth::user();
        $tasks = $user->tasks()->orderBy('created_at', 'desc')->get();

        return response()->json($tasks);
    }

    public function markTaskCompleted(Request $request, $taskId)
    {
        $user = Auth::user();
        $task = Task::where('id', $taskId)
                   ->where('assigned_to', $user->id)
                   ->first();

        if (!$task) {
            return response()->json(['success' => false, 'message' => 'Task not found'], 404);
        }

        $task->update(['status' => 'completed']);

        return response()->json(['success' => true, 'message' => 'Task marked as completed']);
    }
}
