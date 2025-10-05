<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\Proof;
use App\Models\User;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    public function index()
    {
        $complaints = Complaint::with('user', 'assignedUser', 'proof')->latest()->get();
        $availableStaff = User::where('role_id', 2)->get(); // user dengan role 2
        return view('admin.complaints.index', compact('complaints', 'availableStaff'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:diproses,ditolak,selesai,diterima',
            'note' =>
            function ($attribute, $value, $fail) use ($request) {
                if (in_array($request->status, ['diproses', 'ditolak']) && empty($value)) {
                    $fail('Catatan harus diisi jika status adalah diproses atau ditolak.');
                }
            },
        ]);

        $complaint = Complaint::findOrFail($id);
        $complaint->status = $request->status;
        $complaint->note = $request->note ?? null;

        // Default: semua notifikasi dianggap sudah dibaca
        $complaint->read_by_admin = true;
        $complaint->read_by_user = true;
        $complaint->read_by_assigned_user = false;

        // Status-based notifications
        switch ($request->status) {
            case 'terkirim':
                $complaint->read_by_admin = false;
                break;
            case 'diterima':
            case 'ditolak':
                $complaint->read_by_user = false;
                break;
            case 'diproses':
                if ($complaint->assigned_to) {
                    $complaint->read_by_assigned_user = false;
                } else {
                    $complaint->read_by_user = false;
                }

                if ($complaint->proof) {
                    $complaint->read_by_admin = false;
                }
                break;
            case 'selesai':
                $complaint->read_by_user = false;
                break;
        }

        $complaint->save();

        return redirect()->back()->with('success', 'Status pengaduan berhasil diperbarui.');
    }

    public function assignTask(Request $request, $id)
    {
        $request->validate([
            'assigned_to' => 'required|exists:users,id',
        ]);

        $complaint = Complaint::findOrFail($id);
        $complaint->assigned_to = $request->assigned_to;
        $complaint->save();

        return redirect()->back()->with('success', 'Tugas berhasil dikirim ke staff.');
    }
    public function show($id)
    {
        $complaint = Complaint::with('user', 'assignedUser')->findOrFail($id);
        return view('admin.complaints.show', compact('complaint'));
    }
    public function showProof($id)
    {
        $proof = Proof::with('complaint.user')->findOrFail($id);
        return view('admin.complaints.show_proof', compact('proof'));
    }
    public function print($id)
    {
        $complaint = Complaint::with('user')->findOrFail($id);
        return view('admin.complaints.print', compact('complaint'));
    }
    // Cetak bukti pengiriman
    public function printProof($id)
    {
        $complaint = Complaint::with('user', 'proof')->findOrFail($id);

        return view('admin.complaints.print_proof', compact('complaint'));
    }

    // Cetak semua data lengkap
    public function printComplete($id)
    {
        $complaint = Complaint::with('user', 'proof')->findOrFail($id);

        return view('admin.complaints.print_complete', compact('complaint'));
    }
    public function printAssigmentLetter($id)
    {
        $complaint = Complaint::with('user', 'assignedUser')->findOrFail($id);
        return view('admin.complaints.print_assignment_letter', compact('complaint'));
    }
}
