<?php

namespace App\Http\Controllers\Admin;

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
        // Tandai semua artikel sebagai sudah dilihat

        $articles = Article::orderBy('created_at', 'DESC')->get();

        return view('admin.article.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = [];

        if (Auth::user()->role_id == 1) {
            // Jika admin, tampilkan user dengan role_id 2 (kepala inventaris misalnya)
            $users = User::where('id', '!=', Auth::id())->get();
        }

        return view('admin.article.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'banner' => 'required|image', //tambahkan ini untuk mengatur dimensi/ukuran yang diinginkan karena jika tidak sesuai dengan ukuran ini akan error-> |dimensions:min_width=800,min_height=400
            'video' => 'nullable|mimes:mp4,avi,mov,wmv|max:51200', // 50MB
            'description' => 'required',
        ], [
            'banner.dimensions' => 'Ukuran gambar minimal harus 800x400 piksel.',
        ]);

        if ($request->hasFile('banner')) {
            $bannerPath = $request->file('banner')->store('banners', 'public');
        }

        if ($request->hasFile('video')) {
            $videoPath = $request->file('video')->store('videos', 'public');
        }
        Article::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'banner' => $bannerPath,
            'video' => $videoPath ?? null,

            'description' => $request->description,
            'user_id' => auth()->user()->id,
        ]);

        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        return view('admin.article.show', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        $users = [];

        if (Auth::user()->role_id == 1) {
            $users = User::where('id', '!=', Auth::id())
                ->get();
        }

        return view('admin.article.edit', compact('article', 'users'));
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
        ], [
            'banner.dimensions' => 'Ukuran gambar minimal harus 800x400 piksel.',
        ]);

        $data = [
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'description' => $request->description,
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

        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        $article->delete();
        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil dihapus.');
    }
}
