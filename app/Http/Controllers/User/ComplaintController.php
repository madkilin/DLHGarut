<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ComplaintController extends Controller
{

    public function index()
    {
        $complaints = Complaint::where('user_id', auth()->user()->id)->get();
        $availableStaff = User::where('role_id', 2)->get();
        return view('user.complaint.index', [
            'complaints' => $complaints,
            'availableStaff' => $availableStaff
        ]);
    }

    public function create()
    {
        return view('user.complaint.create');
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        // Validasi data yang masuk
        $request->validate([
            'title'         => 'required|string|max:255',
            'description'   => 'required|string',
            'latitude'      => 'nullable|numeric',
            'longitude'     => 'nullable|numeric',
            'kecamatan'     => 'required|string|max:100',
            'desa'     => 'required|string|max:100',
            'kabupaten'     => 'nullable|string|max:100', // Kabupatennya bisa kosong, jika perlu bisa disesuaikan
            'full_address'  => 'required|string|max:255',
            'photos'        => 'required|array|min:1|max:5',
            'photos.*'      => 'image|mimes:jpeg,png,jpg,webp|max:2048', // Maksimal 2MB
            'video'         => 'nullable|mimes:mp4,mov,avi,webm|max:10240', // Maksimal 10MB
        ], [
            'title.required'        => 'Judul laporan harus diisi.',
            'title.string'          => 'Judul laporan harus berupa teks.',
            'title.max'             => 'Judul maksimal 255 karakter.',

            'description.required'  => 'Deskripsi laporan harus diisi.',
            'description.string'    => 'Deskripsi harus berupa teks.',

            'latitude.numeric'      => 'Koordinat latitude harus berupa angka.',
            'longitude.numeric'     => 'Koordinat longitude harus berupa angka.',

            'kecamatan.required'    => 'Nama kecamatan wajib diisi.',
            'kecamatan.string'      => 'Nama kecamatan harus berupa teks.',
            'kecamatan.max'         => 'Nama kecamatan maksimal 100 karakter.',

            'desa.required'    => 'Nama desa wajib diisi.',
            'desa.string'      => 'Nama desa harus berupa teks.',
            'desa.max'         => 'Nama desa maksimal 100 karakter.',

            'kabupaten.string'      => 'Nama kabupaten harus berupa teks.',
            'kabupaten.max'         => 'Nama kabupaten maksimal 100 karakter.',

            'full_address.required' => 'Alamat lengkap harus diisi.',
            'full_address.string'   => 'Alamat lengkap harus berupa teks.',
            'full_address.max'      => 'Alamat lengkap maksimal 255 karakter.',

            'photos.required'       => 'Minimal 1 foto bukti harus diunggah.',
            'photos.array'          => 'Format foto tidak valid.',
            'photos.min'            => 'Minimal 1 foto bukti harus diunggah.',
            'photos.max'            => 'Maksimal hanya 5 foto yang boleh diunggah.',
            'photos.*.image'        => 'Setiap file foto harus berupa gambar.',
            'photos.*.mimes'        => 'Format foto harus jpeg, png, jpg, atau webp.',
            'photos.*.max'          => 'Ukuran setiap foto maksimal 2MB.',

            'video.mimes'           => 'Format video harus mp4, mov, avi, atau webm.',
            'video.max'             => 'Ukuran video maksimal 10MB.',
        ]);

        // Menyimpan foto
        $photoPaths = [];
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                // Pastikan foto disimpan di direktori yang aman
                $photoPaths[] = $photo->store('complaint/photos', 'public');
            }
        }

        // Menyimpan video (jika ada)
        $videoPath = null;
        if ($request->hasFile('video')) {
            $videoPath = $request->file('video')->store('complaint/videos', 'public');
        }

        // Buat pengaduan baru
        $complaint = Complaint::create([
            'user_id' => $user->id, // Tambahkan ini
            'title'         => $request->title,
            'description'   => $request->description,
            'latitude'      => $request->latitude,
            'longitude'     => $request->longitude,
            'kecamatan'     => $request->kecamatan,
            'desa'     => $request->desa,
            'kabupaten'     => $request->kabupaten ?? 'Garut', // Nilai default untuk kabupaten
            'full_address'  => $request->full_address,
            'photos'        => json_encode($photoPaths), // Menyimpan path dalam format JSON
            'video'         => $videoPath,
            'status' => 'terkirim', // Status default

        ]);

        // Menghapus dd() setelah pengujian, karena ini hanya untuk debugging
        return redirect()->route('complaint.index')->with('Success');
    }
    public function show($id)
    {
        $complaint = Complaint::findOrFail($id);
        if (!$complaint->read_by_user) {
            $complaint->update(['read_by_user' => true]);
        }
        return view('user.show', compact('complaint'));
    }
    public function history()
    {

        $user = Auth::user();
        $complaints = Complaint::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.history', compact('complaints'));
    }
}
