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

        $articles = Article::orderBy('created_at','DESC')->get();

        return view('admin.article.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
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
    public function store(Request $request) {}

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
    public function edit(Article $article) {}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        $article->delete();
        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil dihapus.');
    }
}
