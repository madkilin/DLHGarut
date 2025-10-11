<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil lokasi pengaduan untuk peta
        $locations = Complaint::latest()
            ->with('user')
            ->whereIn('status', ['diterima', 'diproses'])
            ->select('title', 'latitude', 'longitude', 'user_id', 'status')
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

        // Query dasar untuk pengaduan
        $complaints = Complaint::query();

        // Jika login sebagai masyarakat (misal role_id = 3), tampilkan hanya miliknya
        if (Auth::check() && Auth::user()->role_id == 3) {
            $complaints->where('user_id', Auth::id());
        }

        // Hitung jumlah pengaduan berdasarkan status
        $complaintCounts = [
            'total' => (clone $complaints)->whereIn('status', ['diproses', 'selesai'])->count(),
            'diproses' => (clone $complaints)->where('status', 'diproses')->count(),
            'selesai' => (clone $complaints)->where('status', 'selesai')->count(),
        ];

        // Tambahkan juga jumlah artikel
        if (Auth::check()) {
            // Kalau user login, tampilkan artikel miliknya
            $complaintCounts['artikel'] = Article::where('user_id', Auth::id())->count();
        } else {
            // Kalau tidak login, tampilkan semua artikel
            $complaintCounts['artikel'] = Article::count();
        }
        // Kirim data ke view
        return view('user.dashboard', [
            'locations' => $locations,
            'complaintCounts' => $complaintCounts,
        ]);
    }
}
