<?php

namespace App\Http\Controllers;

use App\Models\ExchangePoint;
use App\Models\Reward;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ExchangePointController extends Controller
{
    public function index()
    {
        $exchanges = ExchangePoint::where('user_id', auth()->user()->id)->latest()->get();
        return view('user.exchange-point', [
            'exchanges' => $exchanges
        ]);
    }

    public function list()
    {
        $exchanges = ExchangePoint::latest()->get();
        return view('admin.exchange-point.list', [
            'exchanges' => $exchanges
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'reward_id' => 'required',
            'point' => 'required'
        ]);
        $check = ExchangePoint::where('user_id', auth()->user()->id)->where('reward_id', $request->reward_id)->first();
        if ($check) {
            return redirect()->route('user.profile')->with('error', 'Tidak bisa menukarkan dengan hadiah yang sama');
        }
        ExchangePoint::create([
            'reward_id' => $request->reward_id,
            'user_id' => auth()->user()->id,
            'consume_point' => $request->point,
            'status' => 'wait',
            'date' => Carbon::now()
        ]);

        return redirect()->route('user.profile')->with('success', 'Berhasil menukar poin');
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            'status' => 'required'
        ]);
        $exchange = ExchangePoint::find($id);
        $exchange->update([
            'status' => $request->status
        ]);
        if ($request->status == 'confirmed') {
            $user = User::where('id', $exchange->user_id)->first();
            $user->points -= $exchange->consume_point;
            $user->save();

            $reward = Reward::where('id', $exchange->reward_id)->first();
            $reward->quota -= 1;
            $reward->save();
        }
        return redirect()->route('exchange-point.list')->with('success', 'Berhasil mengubah status penukaran');
    }
}
