<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\User;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    public function index()
    {
    $complaints = Complaint::with('user', 'assignedUser')->latest()->get();
    $availableStaff = User::where('role_id', 2)->get(); // user dengan role 2
    return view('admin.complaints.index', compact('complaints', 'availableStaff'));
    }

   public function updateStatus(Request $request, $id)
{
    $request->validate([
        'status' => 'required|in:diproses,ditolak,selesai,diterima',
        'note' => function ($attribute, $value, $fail) use ($request) {
            if (in_array($request->status, ['diproses', 'selesai', 'ditolak']) && empty($value)) {
                $fail('Catatan harus diisi jika status adalah diproses, selesai, atau ditolak.');
            }
        },
    ]);

    $complaint = Complaint::findOrFail($id);
    $complaint->status = $request->status;
    $complaint->note = $request->note ?? null;
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
}
