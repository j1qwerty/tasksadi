<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function loginWithFirebase(Request $request)
    {
        $request->validate([
            'firebase_uid' => 'required|string',
            'email' => 'required|email',
            'name' => 'required|string',
        ]);

        // Find or create user with Firebase UID
        $user = User::where('firebase_uid', $request->firebase_uid)
                   ->orWhere('email', $request->email)
                   ->first();

        if (!$user) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'firebase_uid' => $request->firebase_uid,
                'role' => 'user',
                'password' => bcrypt('firebase_auth'), // Placeholder password
            ]);
        } else {
            // Update Firebase UID if not set
            if (!$user->firebase_uid) {
                $user->update(['firebase_uid' => $request->firebase_uid]);
            }
        }

        Auth::login($user);

        return response()->json([
            'success' => true,
            'user' => $user,
            'redirect' => $user->isAdmin() ? '/admin/dashboard' : '/dashboard'
        ]);
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function registerWithFirebase(Request $request)
    {
        $request->validate([
            'firebase_uid' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'name' => 'required|string',
        ]);

        // Create new user with Firebase UID
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'firebase_uid' => $request->firebase_uid,
            'role' => 'user', // Default role
            'password' => bcrypt('firebase_auth'), // Placeholder password
        ]);

        Auth::login($user);

        return response()->json([
            'success' => true,
            'user' => $user,
            'redirect' => '/dashboard'
        ]);
    }

    public function connectUserToFirebase(Request $request)
    {
        // Check if user is admin
        if (!Auth::user() || !Auth::user()->isAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Admin access required.'
            ], 403);
        }
        
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'firebase_uid' => 'required|string',
        ]);

        $user = User::find($request->user_id);
        
        // Check if Firebase UID is already used
        $existingUser = User::where('firebase_uid', $request->firebase_uid)->first();
        if ($existingUser && $existingUser->id !== $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Firebase UID already connected to another user'
            ], 400);
        }

        $user->update(['firebase_uid' => $request->firebase_uid]);

        return response()->json([
            'success' => true,
            'message' => 'User successfully connected to Firebase',
            'user' => $user
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['success' => true]);
    }
}
