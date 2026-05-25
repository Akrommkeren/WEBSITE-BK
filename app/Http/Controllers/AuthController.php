<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            
            // Ensure role matches email domain on login as well
            if (str_ends_with($user->email, '@bikinkreatif.com')) {
                $user->role = 'staff';
            } elseif (str_ends_with($user->email, '@gmail.com')) {
                $user->role = 'customer';
            }
            
            $user->save();

            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function showRegister()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $role = 'customer';
        if (str_ends_with($request->email, '@bikinkreatif.com')) {
            $role = 'staff';
        } elseif (str_ends_with($request->email, '@gmail.com')) {
            $role = 'customer';
        } else {
            // Default or handle other domains if necessary. 
            // The user only specified @gmail.com and @bikinkreatif.com.
            // I'll assume others are customers for now, or maybe add a validation.
            $role = 'customer';
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $role,
            'division' => 'none', // Default to none as we removed the selection
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
