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
            'nik' => 'required|unique:users,nik|digits:16',
            'phone' => 'required|digits_between:10,13',
            'address' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ], [
            // Pesan custom bahasa Indonesia
            'name.required' => 'Nama wajib diisi.',
            'nik.required' => 'NIK wajib diisi.',
            'nik.digits' => 'NIK harus terdiri dari tepat 16 angka.',
            'nik.unique' => 'NIK sudah terdaftar, silakan gunakan NIK lain.',
            'phone.required' => 'Nomor telepon wajib diisi.',
            'phone.digits_between' => 'Nomor telepon harus terdiri dari 10 hingga 13 angka.',
            'address.required' => 'Alamat wajib diisi.',
            'address.string' => 'Alamat harus berupa teks.',
            'address.max' => 'Alamat tidak boleh lebih dari 255 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar, silakan gunakan email lain.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak sesuai.',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'nik' => $validated['nik'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'email' => $validated['email'],
            'role_id' => 3,
            'password' => bcrypt($validated['password']),
        ]);
        // Login langsung (opsional)
        // Auth::login($user);

        // Kirim email verifikasi
        // $user->sendEmailVerificationNotification();

        // return redirect()->route('verification.notice');
        return redirect()->route('login')->with('success', 'Silakan menunggu Admin sampai memverifikasi akun Anda. Tunggu 1 x 24 jam (Senin - Jumat)');
    }
}
