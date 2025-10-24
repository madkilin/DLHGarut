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
        return view('user.profile', [
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

        // ✅ Tambahkan aturan validasi untuk nik dan phone
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => $emailRules,
            'password' => 'nullable|min:6',
            'address' => 'nullable|string|max:255',
            'nik' => 'nullable|string|max:16|min:16',
            'phone' => 'nullable|string|max:13|min:10',
        ]);

        $emailChanged = $request->filled('email') && $request->email !== $user->email;

        // ✅ Update data jika field diisi
        $user->name = $request->filled('name') ? $request->name : $user->name;
        $user->address = $request->filled('address') ? $request->address : $user->address;
        $user->nik = $request->filled('nik') ? $request->nik : $user->nik;
        $user->phone = $request->filled('phone') ? $request->phone : $user->phone;

        if ($emailChanged) {
            $user->email = $request->email;
            $user->email_verified_at = null;
        }

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

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
            Auth::logout(); // keluarin user dari session
            request()->session()->invalidate();
            request()->session()->regenerateToken();

            return redirect()->route('login')->with('status', 'Email Anda telah diubah. Silakan verifikasi ulang.');
        }
        // ✅ Segarkan session biar data baru langsung muncul
        Auth::setUser($user->fresh());

        return back()->with('success', 'Profil berhasil diperbarui.');
    }
}
