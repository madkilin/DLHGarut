<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first(); // Pastikan ada minimal 1 user

        for ($i = 1; $i <= 12; $i++) {
            Article::create([
                'title' => "Judul Artikel $i",
                'slug' => \Str::slug("Judul Artikel $i") . '-' . $i,
                'user_id' => $user->id,
                'banner' => "build/assets/artikel{$i}.jpg",
                'description' => "Deskripsi lengkap artikel ke-$i. Ini bisa dijadikan konten penuh juga.",
            ]);
        }
    }
}
