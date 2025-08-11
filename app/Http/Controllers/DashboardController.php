<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $locations = Complaint::latest()
            ->with('user')
            ->whereIn('status', ['diterima', 'diproses'])
            ->select('title', 'latitude', 'longitude', 'title', 'user_id', 'status')
            ->get()
            ->map(function ($item) {
                return [
                    'lat' => $item->latitude,
                    'lng' => $item->longitude,
                    'label' => $item->user ? $item->user->name : '-',
                    'status' => $item->status,
                    'title' => $item->title,
                ];
            })
            ->toArray();
        return view('user.dashboard',[
            'locations' => $locations
        ]);
    }
}
