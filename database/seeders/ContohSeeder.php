<?php

namespace Database\Seeders;

use App\Models\Report;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

// Data contoh untuk mencoba saringan dan halaman: php artisan db:seed --class=ContohSeeder
class ContohSeeder extends Seeder
{
    public function run(): void
    {
        $contoh = [
            [1, 'Proyektor tidak menyala', 'Ruang XI RPL 2', 'Proyektor di kelas kami mati sejak Senin, lampu indikatornya berkedip merah.'],
            [2, 'Komputer nomor 7 tidak bisa menyala', 'Lab Komputer 1', 'Komputer nomor 7 hanya berbunyi bip lalu mati lagi.'],
            [3, 'Keran air bocor', 'Toilet lantai 2', 'Keran wastafel bocor terus dan lantainya jadi licin.'],
            [4, 'Stopkontak longgar', 'Ruang X RPL 1', 'Stopkontak di dekat meja guru longgar dan kadang memercik.'],
            [5, 'Lampu baca mati', 'Perpustakaan', 'Dua lampu di sudut baca mati, jadi gelap saat sore.'],
            [6, 'Ring basket patah', 'Lapangan', 'Ring basket sebelah timur patah dan menggantung.'],
            [1, 'Kursi patah', 'Ruang XI RPL 1', 'Ada tiga kursi yang kakinya patah di barisan belakang.'],
            [3, 'Pintu toilet tidak bisa dikunci', 'Toilet lantai 1', 'Kunci pintu toilet paling ujung rusak.'],
        ];
        $siswa = User::where('role', 'siswa')->pluck('id');
        $admin = User::where('role', 'admin')->value('id');

        for ($i = 0; $i < 48; $i++) {
            [$kategori, $judul, $lokasi, $cerita] = $contoh[$i % count($contoh)];
            $waktu = Carbon::create(2026, 11, 17, 9, 30)->subDays($i * 2)->addMinutes($i * 37 % 480);

            $r = new Report(['category_id' => $kategori, 'title' => $judul, 'location' => $lokasi, 'description' => $cerita]);
            $r->user_id = $siswa[$i % count($siswa)];
            $r->status = $i < 5 ? 'baru' : ($i % 7 === 0 ? 'ditolak' : ($i < 12 ? 'diproses' : 'selesai'));
            $r->created_at = $r->updated_at = $waktu;
            $r->save();

            $r->updates()->create(['user_id' => $r->user_id, 'status' => 'baru', 'note' => 'Laporan dibuat.'])
                ->forceFill(['created_at' => $waktu])->save();
            if ($r->status === 'ditolak') {
                $r->updates()->create(['user_id' => $admin, 'status' => 'ditolak', 'note' => 'Barang ini milik kantin, bukan milik sekolah. Silakan sampaikan ke pengelola kantin.'])
                    ->forceFill(['created_at' => $waktu->copy()->addDay()])->save();
            } elseif ($r->status !== 'baru') {
                $r->updates()->create(['user_id' => $admin, 'status' => 'diproses', 'note' => 'Terima kasih. Teknisi dijadwalkan datang besok pagi.'])
                    ->forceFill(['created_at' => $waktu->copy()->addDay()])->save();
                if ($r->status === 'selesai') {
                    $r->updates()->create(['user_id' => $admin, 'status' => 'selesai', 'note' => 'Sudah diperbaiki. Mohon dicek kembali.'])
                        ->forceFill(['created_at' => $waktu->copy()->addDays(3)])->save();
                }
            }
        }
    }
}
