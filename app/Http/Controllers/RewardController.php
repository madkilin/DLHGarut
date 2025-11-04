<?php

namespace App\Http\Controllers;

use App\Models\Reward;
use Illuminate\Http\Request;

class RewardController extends Controller
{
    public function index()
    {
        $rewards = Reward::latest()->get();
        return view('admin.rewards.index', [
            'rewards' => $rewards
        ]);
    }

    public function create()
    {
        return view('admin.rewards.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'quota' => 'required|min:1',
            'minimum' => 'required|min:1',
            'banner' => 'required'
        ], [
            'name.required'    => 'Nama reward wajib diisi.',
            'name.string'      => 'Nama reward harus berupa teks.',
            'name.max'         => 'Nama reward maksimal 255 karakter.',

            'quota.required'   => 'Kuota reward wajib diisi.',
            'quota.integer'    => 'Kuota reward harus berupa angka.',
            'quota.min'        => 'Kuota reward minimal 1.',

            'minimum.required' => 'Poin minimum wajib diisi.',
            'minimum.integer'  => 'Poin minimum harus berupa angka.',
            'minimum.min'      => 'Poin minimum minimal 1.',

            'banner.required'  => 'Gambar banner wajib diunggah.',
            'banner.image'     => 'File banner harus berupa gambar.',
            'banner.mimes'     => 'Format gambar harus jpeg, png, jpg, gif, atau webp.',
            'banner.max'       => 'Ukuran gambar maksimal 2MB.',
        ]);

        if ($request->hasFile('banner')) {
            $bannerPath = $request->file('banner')->store('rewards', 'public');
        }

        Reward::create([
            'name' => $request->name,
            'quota' => $request->quota,
            'point' => $request->minimum,
            'image' => $bannerPath ?? null
        ]);

        return redirect()->route('reward.index')->with('success', 'Hadiah berhasil ditambahkan.');
    }

    public function show(int $id)
    {
        $reward = Reward::find($id);
        return view('admin.rewards.show', [
            'reward' => $reward
        ]);
    }

    public function edit(int $id)
    {
        $reward = Reward::find($id);
        return view('admin.rewards.edit', [
            'reward' => $reward
        ]);
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            'name' => 'required',
            'quota' => 'required|min:1',
            'minimum' => 'required|min:1',
        ], [
            'name.required'    => 'Nama wajib diisi.',
            'name.string'      => 'Nama harus berupa teks.',
            'name.max'         => 'Nama maksimal 255 karakter.',

            'quota.required'   => 'Kuota wajib diisi.',
            'quota.integer'    => 'Kuota harus berupa angka.',
            'quota.min'        => 'Kuota minimal 1.',

            'minimum.required' => 'Nilai minimum wajib diisi.',
            'minimum.integer'  => 'Nilai minimum harus berupa angka.',
            'minimum.min'      => 'Nilai minimum minimal 1.',
        ]);

        $reward = Reward::find($id);

        if ($request->hasFile('banner')) {
            $bannerPath = $request->file('banner')->store('rewards', 'public');
        }

        $reward->update([
            'name' => $request->name,
            'quota' => $request->quota,
            'point' => $request->minimum,
            'image' => $bannerPath ?? $reward->image
        ]);

        return redirect()->route('reward.index')->with('success', 'Hadiah berhasil diupdate.');
    }

    function destroy(int $id)
    {
        $reward = Reward::find($id)->delete();
        return redirect()->route('reward.index')->with('success', 'Reward berhasil dihapus.');
    }
}
