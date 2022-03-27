<?php

namespace Database\Seeders;

use App\Models\Masyarakat;
use App\Models\Pengaduan;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name' => 'admin',
                'username' => 'admin123',
                'password' => Hash::make('admin123'),
                'role' => User::ADMIN,
                'status' => true,
            ],
            [
                'name' => 'petugas',
                'username' => 'petugas123',
                'password' => Hash::make('petugas123'),
                'role' => User::PETUGAS,
                'status' => true,
            ],
        ];

        $masyarakat = [
            [
                'nik' => '12312313',
            ],
            [
                'nik' => '1231212313',
            ],
        ];

        $pengaduans = [
            [
                'nik' => '12312313'
            ],
            [
                'nik' => '1231212313'
            ],
        ];

        foreach ($users as $user) {
            User::factory($user)->create();
        }

        foreach ($masyarakat as $user) {
            Masyarakat::factory($user)->create();
        }

        foreach ($pengaduans as $pengaduan) {
            Pengaduan::factory($pengaduan)->create();
        }
    }
}
