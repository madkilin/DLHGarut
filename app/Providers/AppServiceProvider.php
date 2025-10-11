<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Article;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('layout.admin.navbar', function ($view) {
            $newArticlesCount = Article::where('is_read_by_admin', false)->count();
            $newUserCount = User::where('is_read_by_admin', false)->count();
            $newComplaintsCount = \App\Models\Complaint::whereNotIn('status', ['selesai', 'ditolak'])->count();
            $newComplaintsPetugasCount = \App\Models\Complaint::where('read_by_assigned_user', false)->count();
            $newComplaintsUserCount = \App\Models\Complaint::where('read_by_user', false)->count();


            $view->with([
                'newArticlesCount' => $newArticlesCount,
                'newUserCount' => $newUserCount,
                'newComplaintsCount' => $newComplaintsCount,
                'newComplaintsPetugasCount' => $newComplaintsPetugasCount,
                'newComplaintsUserCount' => $newComplaintsUserCount
            ]);
        });
        View::composer('layout.petugas.navbar', function ($view) {
            $newComplaintsPetugasCount = \App\Models\Complaint::where('read_by_assigned_user', 0)
                ->where('assigned_to', Auth::id())
                ->count();

            $view->with([

                'newComplaintsPetugasCount' => $newComplaintsPetugasCount,
            ]);
        });
        View::composer('layout.navbar', function ($view) {
            $newComplaintsUserCount = \App\Models\Complaint::where('read_by_user', false)->count();


            $view->with([
                'newComplaintsUserCount' => $newComplaintsUserCount
            ]);
        });
    }
}
