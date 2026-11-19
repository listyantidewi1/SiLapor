<?php

namespace Tests\Feature;

use App\Models\Report;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class LaporanTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
        $this->lina = User::where('email', 'lina@nusabakti.test')->first();
        $this->dimas = User::where('email', 'dimas@nusabakti.test')->first();
        $this->hendra = User::where('email', 'hendra@nusabakti.test')->first();
    }

    private function laporan(User $pemilik, string $status = 'baru'): Report
    {
        $r = new Report(['category_id' => 1, 'title' => 'Proyektor tidak menyala', 'location' => 'Ruang XI RPL 2', 'description' => 'Mati total.']);
        $r->user_id = $pemilik->id;
        $r->status = $status;
        $r->save();

        return $r;
    }

    public function test_tamu_diarahkan_ke_halaman_masuk(): void
    {
        $this->get('/laporan')->assertRedirect('/masuk');
    }

    public function test_siswa_tidak_bisa_membuka_laporan_siswa_lain(): void
    {
        $milikLina = $this->laporan($this->lina);

        $this->actingAs($this->dimas)->get("/laporan/{$milikLina->id}")->assertForbidden();
        $this->actingAs($this->lina)->get("/laporan/{$milikLina->id}")->assertOk();
    }

    public function test_siswa_tidak_bisa_membuka_halaman_kelola(): void
    {
        $this->actingAs($this->lina)->get('/kelola')->assertForbidden();
        $this->actingAs($this->hendra)->get('/kelola')->assertOk();
    }

    public function test_pendaftar_tidak_bisa_menjadikan_dirinya_admin(): void
    {
        $this->post('/daftar', [
            'name' => 'Iseng', 'classroom' => 'XII Z', 'email' => 'iseng@contoh.test',
            'password' => 'rahasia123', 'password_confirmation' => 'rahasia123', 'role' => 'admin',
        ]);

        $this->assertSame('siswa', User::where('email', 'iseng@contoh.test')->first()->role);
    }

    public function test_status_selesai_tidak_bisa_kembali_ke_baru(): void
    {
        $r = $this->laporan($this->lina, 'selesai');

        $this->actingAs($this->hendra)
            ->post("/kelola/{$r->id}/tanggapan", ['status' => 'baru', 'note' => 'Coba dibuka lagi'])
            ->assertSessionHasErrors('status');

        $this->assertSame('selesai', $r->fresh()->status);
    }

    public function test_perubahan_status_tercatat_di_riwayat(): void
    {
        $r = $this->laporan($this->lina);

        $this->actingAs($this->hendra)
            ->post("/kelola/{$r->id}/tanggapan", ['status' => 'diproses', 'note' => 'Teknisi datang besok.']);

        $this->assertSame('diproses', $r->fresh()->status);
        $this->assertDatabaseHas('report_updates', ['report_id' => $r->id, 'status' => 'diproses', 'note' => 'Teknisi datang besok.']);
    }

    public function test_berkas_bukan_gambar_ditolak(): void
    {
        Storage::fake();

        $this->actingAs($this->lina)->post('/laporan', [
            'category_id' => 1, 'title' => 'Uji', 'location' => 'Lab Komputer 1', 'description' => 'Uji.',
            'photo' => UploadedFile::fake()->create('jahat.php', 10, 'application/x-php'),
        ])->assertSessionHasErrors('photo');

        $this->assertSame(0, Report::count());
    }

    public function test_foto_disimpan_dengan_nama_acak(): void
    {
        Storage::fake();

        $this->actingAs($this->lina)->post('/laporan', [
            'category_id' => 1, 'title' => 'Uji', 'location' => 'Lab Komputer 1', 'description' => 'Uji.',
            'photo' => UploadedFile::fake()->image('rumah-saya.jpg', 800, 600),
        ])->assertRedirect();

        $foto = Report::first()->photo;
        $this->assertStringNotContainsString('rumah-saya', $foto);
        Storage::assertExists($foto);
    }
}
