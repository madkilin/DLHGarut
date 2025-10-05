<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\User;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function index()
    {
        $articles = Article::where('is_read_by_admin', 1)->latest()->get();
        $users = User::where('role_id', 3)->orderBy('level', 'desc')->orderBy('exp', 'desc')->limit(10)->get();
        return view('landingPage', [
            'articles' => $articles,
            'users' => $users
        ]);
    }
}
