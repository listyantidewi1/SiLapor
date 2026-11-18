<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['Ruang kelas', 'Laboratorium', 'Toilet', 'Listrik dan lampu', 'Perpustakaan', 'Lapangan dan kantin'] as $nama) {
            Category::create(['name' => $nama]);
        }

        // Akun contoh. Kata sandi semuanya: rahasia123
        $hendra = User::create(['name' => 'Pak Hendra', 'classroom' => 'Sarana prasarana', 'email' => 'hendra@nusabakti.test', 'password' => 'rahasia123']);
        $hendra->role = 'admin';
        $hendra->save();

        User::create(['name' => 'Lina', 'classroom' => 'XI RPL 1', 'email' => 'lina@nusabakti.test', 'password' => 'rahasia123']);
        User::create(['name' => 'Dimas', 'classroom' => 'XI RPL 2', 'email' => 'dimas@nusabakti.test', 'password' => 'rahasia123']);
    }
}
