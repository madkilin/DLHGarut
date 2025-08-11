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
}
