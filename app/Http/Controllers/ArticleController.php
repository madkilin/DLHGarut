<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\User;
use Illuminate\Http\Request;

class ArticleController extends Controller
{public function index(Request $request)
{
    $query = Article::query();

    if ($request->filled('search')) {
        $search = $request->search;

        $query->where(function ($q) use ($search) {
            $q->where('title', 'like', '%' . $search . '%')
              ->orWhere('description', 'like', '%' . $search . '%')
              ->orWhereHas('user', function ($uq) use ($search) {
                  $uq->where('name', 'like', '%' . $search . '%');
              });
        });
    }

    $query->orderBy('created_at', 'desc');

    $isFirstPage = !$request->has('page') || $request->page == 1;

    $highlightArticles = $isFirstPage ? $query->take(4)->with('user')->get() : null;

    // Skip highlight if needed, load with user relation
    $articles = $query->with('user')
                      ->when($highlightArticles, function ($q) {
                          return $q->skip(4);
                      })
                      ->paginate(9)
                      ->withQueryString();

    // Bisa dihapus jika dropdown user sudah tidak digunakan di view
    $users = User::all();

    return view('article.index', compact('highlightArticles', 'articles', 'users', 'isFirstPage'));
}

    public function show($slug)
    {
        $article = Article::where('slug', $slug)->firstOrFail();
        return view('article.show', compact('article'));
    }
}
