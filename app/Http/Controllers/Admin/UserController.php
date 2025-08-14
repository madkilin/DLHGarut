<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = \App\Models\Role::whereIn('id', [2, 3])->get();
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role_id' => 'required|in:2,3',
            'nik' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'address' => 'required|string|max:255',

        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
            'status' => 'belum diverifikasi', // default
            'nik' => $request->nik,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan.');
    }


    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.show', compact('user'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6',
            'status' => 'required|in:active,nonactive,belum diverifikasi',
            'nik' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'address' => 'required|string|max:255',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->status = $request->status;
        $user->nik = $request->nik;
        $user->phone = $request->phone;
        $user->address = $request->address;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui.');
    }

    public function updateStatus(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $user->status = $request->status;

        // if ($request->status === 'nonactive') {
        //     // Simpan deskripsi alasan jika ada
        //     // $user->note = $request->keterangan === 'manual' ? $request->keterangan_manual : $request->keterangan;
        // } else {
        //     // $user->note = null; // Kosongkan jika bukan nonactive
        // }
        $user->is_read_by_admin = true;

        $user->save();

        return redirect()->route('users.index')->with('success', 'Status user berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
    }

    public function reset()
    {
        User::where('role_id', 3)->update([
            'exp' => 0,
            'points' => 0,
            'level' => 1
        ]);

        return redirect()->route('users.index')
            ->with('success', 'Exp & Level berhasil di reset');
    }
}
