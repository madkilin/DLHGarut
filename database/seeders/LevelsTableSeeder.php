<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class LevelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('levels')->insert([
            ['level' => 1, 'required_exp' => 100],
            ['level' => 2, 'required_exp' => 250],
            ['level' => 3, 'required_exp' => 375],
            ['level' => 4, 'required_exp' => 500],
            ['level' => 5, 'required_exp' => 700],
            // Tambahkan lebih banyak sesuai kebutuhan
        ]);
    }
}
