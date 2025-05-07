<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class RegisterController extends Controller
{

    public function showRegistrationForm()
    {
        return view('auth.register'); // Sesuaikan view kamu
    }
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);

        // Login langsung (opsional)
        Auth::login($user);

        // Kirim email verifikasi
        $user->sendEmailVerificationNotification();

        return redirect()->route('verification.notice');
    }
}
