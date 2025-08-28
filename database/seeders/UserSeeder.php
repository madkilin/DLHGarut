<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'Administrator',
                'nik' => '12345',
                'phone' => '081111',
                'address' => 'alamat 1',
                'email' => 'admin@mail.com',
                'role_id' => 1
            ],
            [
                'name' => 'Petugas Lapangan',
                'nik' => '12345',
                'phone' => '081111',
                'address' => 'alamat 2',
                'email' => 'petugas@mail.com',
                'role_id' => 2
            ],
            [
                'name' => 'Masyarakat',
                'nik' => '12345',
                'phone' => '081111',
                'address' => 'alamat 1',
                'email' => 'masyarakat@mail.com',
                'role_id' => 3
            ],
        ];

        foreach ($data as $value) {
            User::updateOrCreate([
                'email' => $value['email']
            ],[
                'password' => bcrypt('password'),
                'name' => $value['name'],
                'nik' => $value['nik'],
                'phone' => $value['phone'],
                'address' => $value['address'],
                'role_id' => $value['role_id']
            ]);
        }
    }
}
