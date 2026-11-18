<?php

// Pesan validasi berbahasa Indonesia (hanya aturan yang dipakai SiLapor)
return [
    'required' => ':attribute wajib diisi.',
    'email' => ':attribute harus berupa alamat email.',
    'unique' => ':attribute sudah terdaftar.',
    'confirmed' => 'Ulangan :attribute tidak sama.',
    'exists' => ':attribute tidak ditemukan.',
    'mimes' => ':attribute harus berupa berkas :values.',
    'uploaded' => ':attribute gagal diunggah.',
    'date_format' => 'Format :attribute tidak dikenali.',
    'integer' => ':attribute harus berupa angka.',
    'in' => ':attribute tidak dikenali.',
    'min' => ['string' => ':attribute minimal :min karakter.'],
    'max' => [
        'string' => ':attribute maksimal :max karakter.',
        'file' => ':attribute maksimal :max kilobyte.',
    ],
    'attributes' => [
        'name' => 'Nama', 'classroom' => 'Kelas', 'email' => 'Email', 'password' => 'Kata sandi',
        'category_id' => 'Kategori', 'title' => 'Judul', 'location' => 'Lokasi',
        'description' => 'Cerita masalah', 'photo' => 'Foto', 'note' => 'Umpan balik', 'status' => 'Status',
    ],
];
