<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Reward;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{

    public function index()
    {
        $rewards = Reward::where('quota', '>', 1)->latest()->get();
        return view('user.profile',[
            'rewards' => $rewards
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $emailRules = ['nullable', 'email', 'max:255'];
        if ($request->email !== $user->email) {
            $emailRules[] = 'unique:users,email';
        }
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => $emailRules,
            'password' => 'nullable|min:6',
            'address' => 'nullable|string|max:255',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Cek email diubah
        $emailChanged = $request->filled('email') && $request->email !== $user->email;

        // Update data kalau diisi, kalau kosong biarkan
        $user->name = $request->filled('name') ? $request->name : $user->name;
        $user->address = $request->filled('address') ? $request->address : $user->address;

        if ($emailChanged) {
            $user->email = $request->email;
            $user->email_verified_at = null; // wajib verifikasi ulang
        }

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        // Handle upload foto
        if ($request->hasFile('profile_photo')) {
            if ($user->profile_photo) {
                Storage::delete('public/profile_photos/' . $user->profile_photo);
            }

            $file = $request->file('profile_photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('profile_photos', $filename, 'public');
            $user->profile_photo = $filename;
        }

        $user->save();

        if ($emailChanged) {
            $user->sendEmailVerificationNotification();
            return redirect()->route('verification.notice')->with('status', 'Email Anda telah diubah. Silakan verifikasi ulang.');
        }

        return back()->with('success', 'Profil berhasil diperbarui.');
    }
}
