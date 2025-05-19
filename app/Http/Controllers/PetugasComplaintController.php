<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class PetugasComplaintController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $complaints = Complaint::with('user')
            ->where('assigned_to', $userId)
            ->latest()
            ->get();

        return view('petugasLapangan.complaints.index', compact('complaints'));
    }
    public function show($id)
    {
        $complaint = Complaint::with('user')->findOrFail($id);
        return view('petugasLapangan.complaints.show', compact('complaint'));
    }
}
