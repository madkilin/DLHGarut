<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class DashboardController extends Controller
{
    public function index()
    {
           // Ambil semua pengaduan yang ditugaskan ke user yang sedang login
    $complaints = Complaint::where('assigned_to', Auth::id());

    // Hitung jumlah pengaduan berdasarkan status
    $complaintCounts = [
        'total' => $complaints->count(),

        'diproses' => (clone $complaints)->where('status', 'diproses')->count(),
        'selesai' => (clone $complaints)->where('status', 'selesai')->count(),
    ];

    return view('petugasLapangan.dashboard', compact('complaintCounts'));
    }
}
