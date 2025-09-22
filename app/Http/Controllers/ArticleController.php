<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleUserRead;
use App\Models\ProgressLog;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $query = Article::where('is_read_by_admin', 1);

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

        $articles = $query->with('user')
            ->when($highlightArticles, function ($q) {
                return $q->skip(4);
            })
            ->paginate(9)
            ->withQueryString();

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
            ProgressLog::action($user, 10, 'exp', 'Membaca Artikel');
            $user->points += 10;
            ProgressLog::action($user, 10, 'point', 'Membaca Artikel');
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
        if ($user) {
            $today = Carbon::today()->toDateString();

            $alreadyReadToday = $user->readArticles()
                ->where('article_id', $article->id)
                ->wherePivot('read_at', $today)
                ->exists();

            return response()->json([
                'claimed' => $alreadyReadToday,
            ]);
        }
    }

    // POST reward klaim
    public function claimReward(Article $article)
    {
        dd('ppp');
        $user = Auth::user();
        if ($user) {
            $today = Carbon::today()->toDateString();

            $alreadyReadToday = $user->readArticles()
                ->where('article_id', $article->id)
                ->wherePivot('read_at', $today)
                ->exists();

            if (!$alreadyReadToday) {
                $user->addExp(10);
                ProgressLog::action($user, 10, 'exp', 'Membaca Artikel');
                $user->points += 10;
                ProgressLog::action($user, 10, 'point', 'Membaca Artikel');
                $user->save();
                $user->readArticles()->attach($article->id, ['read_at' => $today]);

                return response()->json(['message' => 'Reward diberikan']);
            }

            return response()->json(['message' => 'Sudah dapat reward hari ini']);
        }
    }

    public function list()
    {
        $articles = Article::when(auth()->user(), function ($query) {
            $query->where('user_id', auth()->user()->id);
        })->orderBy('created_at', 'DESC')->get();
        return view('article.list', [
            'articles' => $articles
        ]);
    }

    public function create()
    {
        return view('article.create');
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'banner' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video' => 'nullable|mimes:mp4,avi,mov,wmv|max:51200' // 50MB
        ]);
        $slug = Str::slug($request->title);
        if ($request->hasFile('banner')) {
            $bannerPath = $request->file('banner')->store('banners', 'public');
        }

        if ($request->hasFile('video')) {
            $videoPath = $request->file('video')->store('videos', 'public');
        }
        Article::create([
            'user_id' => auth()->user()->id,
            'title' => $request->title,
            'slug' => $slug,
            'description' => $request->description,
            'banner' => $bannerPath ?? null,
            'video' => $videoPath ?? null,
        ]);

        return redirect()->route('article.list')->with('success', 'Artikel berhasil ditambahkan.');
    }

    public function edit(int $id)
    {
        $article = Article::find($id);
        return view('article.edit', [
            'article' => $article
        ]);
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            'title' => 'required|unique:articles,title,' . $id,
            'description' => 'required',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video' => 'nullable|mimes:mp4,avi,mov,wmv|max:51200' // 50MB
        ]);

        $article = Article::where('id', $id)->first();
        $slug = Str::slug($request->title);
        $bannerPath = $article->banner;
        $videoPath = $article->video;

        if ($request->hasFile('banner')) {
            $bannerPath = $request->file('banner')->store('banners', 'public');
            Storage::delete($article->banner);
        }

        if ($request->hasFile('video')) {
            $videoPath = $request->file('video')->store('videos', 'public');
            Storage::delete($article->video);
        }
        $article->update([
            'title' => $request->title,
            'slug' => $slug,
            'description' => $request->description,
            'banner' => $bannerPath ?? null,
            'video' => $videoPath ?? null,
        ]);

        return redirect()->route('article.list')->with('success', 'Artikel berhasil ditambahkan.');
    }

    public function updateStatus(Request $request, $id)
    {
        // dd($request->all());
        DB::beginTransaction();
        $article = Article::find($id);
        $user = User::where('id', $article->user_id)->first();
        $article->is_read_by_admin = $request->status;

        if ($request->status == 1) {
            $article->confirmed_at = Carbon::now();
            if ($user) {
                $user->addExp(10); // Menambahkan EXP
                ProgressLog::action($user, 10, 'exp', 'Artikel di terima');
                $user->points += 10; // Menambahkan POINT
                ProgressLog::action($user, 10, 'point', 'Artikel di terima');
                $user->save();
            }
        }

        if ($request->status == -1) {
            $article->alasan_penolakan = $request->reason;
        }

        $data = $article->save();
        if ($data) {
            DB::commit();
            return redirect('/admin/articles')->with('success', 'Artikel berhasil dikonfirmasi.');
        } else {
            Db::rollBack();
            return redirect('/admin/articles')->with('error', 'Artikel gagal dikonfirmasi.');
        }
    }

    public function detail(string $slug)
    {
        $article = Article::whereSlug($slug)->first();
        Log::info('article : ', ['data' => $article]);
        if (auth()->user()) {
            Log::info('in if auth');
            ArticleUserRead::updateOrCreate([
                'article_id' => $article->id
            ], [
                'user_id' => auth()->user()->id,
                'read_at' => Carbon::now()
            ]);
            $creator = User::where('id', $article->user_id)->first();
            $reader = auth()->user();
            Log::info('creator', ['data' => $creator]);
            if ($creator) {
                $creator->addExp(1); // Menambahkan EXP
                ProgressLog::action($creator, 1, 'exp', "Artikel dibaca oleh " . $reader->name);
                $creator->points += 1; // Menambahkan POINT
                ProgressLog::action($creator, 1, 'point', "Artikel dibaca oleh " . $reader->name);
                $creator->save();
                Log::info('update creator : ', ['data' => $creator]);

                $reader->addExp(1); // Menambahkan EXP
                ProgressLog::action($reader, 1, 'exp', "Membaca Artikel " . $creator->name);
                $reader->points += 1; // Menambahkan POINT
                ProgressLog::action($reader, 1, 'point', "Membaca Artikel " . $creator->name);
                $reader->save();
                Log::info('update reader : ', ['data' => $creator]);
            }
        }
        return view('article-detail', [
            'article' => $article
        ]);
    }

    public function listData()
    {
        $articles = Article::latest()->get();
        return view('article.list-data', [
            'articles' => $articles
        ]);
    }
}
