<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ReportController extends Controller
{
    public function submitReport(Request $request)
    {
        // Validasi dan simpan laporan...

        $user = auth()->user();
        if (!$user) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        return redirect()->back()->with('success', 'Laporan berhasil! Kamu dapat 20 EXP!');
    }
}
