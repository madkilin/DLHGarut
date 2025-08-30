<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Complaint;
use App\Models\RewardHistory;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $users = User::where('role_id', '!=', 1);
        $totalUsers = $users->count();
        $totalArticles = Article::count();
        $totalRewardHistories = RewardHistory::count();
        $totalPetugas = (clone $users)->where('role_id', 2)->count();
        $totalMasyarakat = (clone $users)->where('role_id', 3)->count();

        $masyarakatAktif = User::where('role_id', 3)->where('status', 'active')->count();
        $masyarakatNonaktif = User::where('role_id', 3)->where('status', 'nonactive')->count();

        // Gunakan clone agar query tidak bentrok
        $complaints = Complaint::query();
        $complaintCounts = [
            'total' => $complaints->count(),
            'terkirim' => (clone $complaints)->where('status', 'terkirim')->count(),
            'diterima' => (clone $complaints)->where('status', 'diterima')->count(),
            'diproses' => (clone $complaints)->where('status', 'diproses')->count(),
            'ditolak' => (clone $complaints)->where('status', 'ditolak')->count(),
            'selesai' => (clone $complaints)->where('status', 'selesai')->count(),
        ];

        $locations = Complaint::latest()
            ->with('user')
            ->whereIn('status', ['diterima', 'diproses'])
            ->select('id', 'title', 'latitude', 'longitude', 'title', 'user_id', 'status')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'lat' => $item->latitude,
                    'lng' => $item->longitude,
                    'label' => $item->user ? $item->user->name : '-',
                    'status' => $item->status,
                    'title' => $item->title,
                ];
            })
            ->toArray();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalArticles',
            'totalRewardHistories',
            'locations',
            'totalPetugas',
            'totalMasyarakat',
            'masyarakatAktif',
            'masyarakatNonaktif',
            'complaintCounts'
        ));
    }
}
