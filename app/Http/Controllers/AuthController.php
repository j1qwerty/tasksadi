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

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['success' => true]);
    }
}
