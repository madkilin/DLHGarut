<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
{
    $users = User::where('role_id', '!=', 1);
    $totalUsers = $users->count();
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

    return view('admin.dashboard', compact(
        'totalUsers',
        'totalPetugas',
        'totalMasyarakat',
        'masyarakatAktif',
        'masyarakatNonaktif',
        'complaintCounts'
    ));
}

}
