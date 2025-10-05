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
                'nik' => '1234567890123451',
                'phone' => '08123456781',
                'address' => 'alamat 1',
                'email' => 'admin@mail.com',
                'role_id' => 1
            ],
            [
                'name' => 'Administrator 2',
                'nik' => '1234567890123452',
                'phone' => '08123456782',
                'address' => 'alamat 2',
                'email' => 'admin2@mail.com',
                'role_id' => 1
            ],
            [
                'name' => 'Petugas Lapangan',
                'nik' => '1234567890123453',
                'phone' => '08123456783',
                'address' => 'alamat 3',
                'email' => 'petugas@mail.com',
                'role_id' => 2
            ],
            [
                'name' => 'Petugas Lapangan 2',
                'nik' => '1234567890123454',
                'phone' => '08123456784',
                'address' => 'alamat 4',
                'email' => 'petugas2@mail.com',
                'role_id' => 2
            ],
            [
                'name' => 'Masyarakat 1',
                'nik' => '1234567890123455',
                'phone' => '081234567811',
                'address' => 'alamat a',
                'email' => 'masyarakat@mail.com',
                'role_id' => 3
            ],
            [
                'name' => 'Masyarakat 2',
                'nik' => '1234567890123456',
                'phone' => '081234567812',
                'address' => 'alamat b',
                'email' => 'masyarakat2@mail.com',
                'role_id' => 3
            ],
            [
                'name' => 'Masyarakat 3',
                'nik' => '1234567890123457',
                'phone' => '081234567813',
                'address' => 'alamat c',
                'email' => 'masyarakat3@mail.com',
                'role_id' => 3
            ],
            [
                'name' => 'Masyarakat 4',
                'nik' => '1234567890123458',
                'phone' => '081234567814',
                'address' => 'alamat d',
                'email' => 'masyarakat4@mail.com',
                'role_id' => 3
            ],
            [
                'name' => 'Masyarakat 5',
                'nik' => '1234567890123459',
                'phone' => '081234567815',
                'address' => 'alamat e',
                'email' => 'masyarakat5@mail.com',
                'role_id' => 3
            ],
        ];

        foreach ($data as $value) {
            User::updateOrCreate([
                'email' => $value['email']
            ], [
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
