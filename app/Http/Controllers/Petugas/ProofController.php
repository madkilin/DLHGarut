<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\Proof;
use Illuminate\Http\Request;

class ProofController extends Controller
{
    public function create($id)
    {
        $complaint = Complaint::findOrFail($id);
        return view('petugasLapangan.proof.create', compact('complaint'));
    }
    public function show($id)
    {
        $proof = Proof::with('complaint.user')->findOrFail($id);
        return view('petugasLapangan.proof.show', compact('proof'));
    }
    public function store(Request $request, $id)
    {
        $request->validate([
            'description' => 'required|string',
            'officers' => 'nullable|array',
            'officers.*' => 'nullable|string|max:255',
            'amount' => 'required|integer',
            'unit' => 'required|string|max:50',
            'photos.*' => 'required|image|max:2048',
        ]);

        $photoPaths = [];
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $photoPaths[] = $photo->store('proof_photos', 'public');
            }
        }

        Proof::create([
            'complaint_id' => $id,
            'description' => $request->description,
            'officers' => $request->officers,
            'amount' => $request->amount,
            'unit' => $request->unit,
            'photos' => $photoPaths,
        ]);

        return redirect()->route('petugas.complaints.index')->with('success', 'Bukti berhasil dikirim.');
    }
}
