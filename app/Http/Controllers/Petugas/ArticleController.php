<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = Article::with('user')->latest()->get();
        return view('petugasLapangan.article.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = [];

        if (Auth::user()->role_id == 1) {
            // Jika admin, tampilkan user dengan role_id 2 (kepala inventaris misalnya)
            $users = User::where('id', '!=', Auth::id())
                ->where('role_id', 2)
                ->get();
        }

        return view('petugasLapangan.article.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'banner' => 'required|image', //tambahkan ini untuk mengatur dimensi/ukuran yang diinginkan karena jika tidak sesuai dengan ukuran ini akan error-> |dimensions:min_width=800,min_height=400
            'description' => 'required',
            'user_id' => 'nullable|exists:users,id',
        ], [
            'banner.dimensions' => 'Ukuran gambar minimal harus 800x400 piksel.',
        ]);

        $path = $request->file('banner')->store('banners', 'public');

        Article::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'banner' => $path,
            'description' => $request->description,
            'user_id' => Auth::user()->role_id == 1 ? $request->user_id : Auth::id(),
        ]);

        return redirect()->route('petugas.articles.index')->with('success', 'Artikel berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        return view('petugasLapangan.article.show', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        $users = [];

        if (Auth::user()->role_id == 1) {
            $users = User::where('id', '!=', Auth::id())
                ->where('role_id', 2)
                ->get();
        }

        return view('petugasLapangan.article.edit', compact('article', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {
        $request->validate([
            'title' => 'required|max:255',
            'banner' => 'nullable|image|dimensions:min_width=800,min_height=400',
            'description' => 'required',
            'user_id' => 'nullable|exists:users,id',
        ], [
            'banner.dimensions' => 'Ukuran gambar minimal harus 800x400 piksel.',
        ]);

        $data = [
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'description' => $request->description,
            'user_id' => Auth::user()->role_id == 1 ? $request->user_id : Auth::id(),
        ];
        // Reset notifikasi admin jika petugas yang update
        if (Auth::user()->role_id != 1) {
            $data['is_read_by_admin'] = false;
        }

        // Perbarui gambar jika ada
        if ($request->hasFile('banner')) {
            $data['banner'] = $request->file('banner')->store('banners', 'public');
        }

        $article->update($data);

        return redirect()->route('petugas.articles.index')->with('success', 'Artikel berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        $article->delete();
        return redirect()->route('petugas.articles.index')->with('success', 'Artikel berhasil dihapus.');
    }
}
