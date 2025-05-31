<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index(Request $request)
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
    public function reward(Request $request, Article $article)
    {
        $user = Auth::user();
        $today = Carbon::today()->toDateString();

        $alreadyReadToday = $user->readArticles()
            ->where('article_id', $article->id)
            ->wherePivot('read_at', $today)
            ->exists();

        if (!$alreadyReadToday) {
            $user->addExp(10);
            $user->points += 10;
            $user->save();

            $user->readArticles()->attach($article->id, ['read_at' => $today]);

            return response()->json(['message' => 'Reward diberikan']);
        }

        return response()->json(['message' => 'Sudah dapat reward hari ini']);
    }
    // GET reward status
    public function checkRewardStatus(Article $article)
    {
        $user = Auth::user();
        $today = Carbon::today()->toDateString();

        $alreadyReadToday = $user->readArticles()
            ->where('article_id', $article->id)
            ->wherePivot('read_at', $today)
            ->exists();

        return response()->json([
            'claimed' => $alreadyReadToday,
        ]);
    }

    // POST reward klaim
    public function claimReward(Article $article)
    {
        $user = Auth::user();
        $today = Carbon::today()->toDateString();

        $alreadyReadToday = $user->readArticles()
            ->where('article_id', $article->id)
            ->wherePivot('read_at', $today)
            ->exists();

        if (!$alreadyReadToday) {
            $user->addExp(10);
            $user->points += 10;
            $user->save();
            $user->readArticles()->attach($article->id, ['read_at' => $today]);

            return response()->json(['message' => 'Reward diberikan']);
        }

        return response()->json(['message' => 'Sudah dapat reward hari ini']);
    }
}
