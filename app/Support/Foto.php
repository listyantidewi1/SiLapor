<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Foto
{
    // Simpan foto sebagai JPEG baru: nama acak, tanpa data lokasi (EXIF)
    public static function simpan(UploadedFile $file): string
    {
        $gambar = imagecreatefromstring($file->get());
        $gambar = imagescale($gambar, min(imagesx($gambar), 1600));

        $nama = 'foto/' . Str::random(40) . '.jpg';
        ob_start();
        imagejpeg($gambar, null, 82);
        Storage::put($nama, ob_get_clean());

        return $nama;
    }
}
