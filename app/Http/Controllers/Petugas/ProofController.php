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
        ], [
            'description.required' => 'Deskripsi penyelesaian harus diisi.',
            'description.string' => 'Deskripsi harus berupa teks yang valid.',

            'officers.array' => 'Format data petugas tambahan tidak valid.',
            'officers.*.string' => 'Nama setiap petugas harus berupa teks.',
            'officers.*.max' => 'Nama petugas maksimal 255 karakter.',

            'amount.required' => 'Jumlah sampah harus diisi.',
            'amount.integer' => 'Jumlah sampah harus berupa angka.',

            'unit.required' => 'Satuan jumlah sampah harus diisi.',
            'unit.string' => 'Satuan harus berupa teks.',
            'unit.max' => 'Satuan maksimal 50 karakter.',

            'photos.*.required' => 'Setiap foto bukti penyelesaian wajib diunggah.',
            'photos.*.image' => 'File yang diunggah harus berupa gambar (jpg, png, jpeg, dll).',
            'photos.*.max' => 'Ukuran setiap foto maksimal 2MB.',
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
        // Update notifikasi petugas: sudah dibaca
        $complaint = Complaint::findOrFail($id);
        $complaint->read_by_assigned_user = true;
        $complaint->read_by_admin = false;
        $complaint->save();
        return redirect()->route('petugas.complaints.index')->with('success', 'Bukti berhasil dikirim.');
    }
}
