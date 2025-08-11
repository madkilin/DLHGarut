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
        $levels = [];

        $requiredExp = 0;
        for ($level = 1; $level <= 21; $level++) {
            $levels[] = [
                'level' => $level,
                'required_exp' => $requiredExp,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $requiredExp += 10; // setiap level naik 10 XP
        }

        DB::table('levels')->insert($levels);
    }
}
