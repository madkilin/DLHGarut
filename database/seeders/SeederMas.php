<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SeederMas extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [            [
                'name' => 'Masyarakat2',
                'nik' => '123451',
                'phone' => '0813111',
                'address' => 'alamat 1',
                'email' => 'masyarakat2@mail.com',
                'role_id' => 3
            ],
            [
                'name' => 'Masyarakat3',
                'nik' => '123452',
                'phone' => '0811121',
                'address' => 'alamat 1',
                'email' => 'masyarakat3@mail.com',
                'role_id' => 3
            ],
            [
                'name' => 'Masyarakat4',
                'nik' => '123453',
                'phone' => '0811111',
                'address' => 'alamat 1',
                'email' => 'masyarakat4@mail.com',
                'role_id' => 3
            ],
            [
                'name' => 'Masyarakat5',
                'nik' => '123454',
                'phone' => '0811411',
                'address' => 'alamat 1',
                'email' => 'masyarakat5@mail.com',
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
