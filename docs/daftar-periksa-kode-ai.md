# Daftar periksa kode buatan AI

Daftar ini merangkum segmen "Cek kerjaan AI" di video. Pakailah setiap kali AI menyodorkan kode untuk aplikasi web, apa pun framework-nya. Kode yang berjalan belum tentu benar, jadi setiap butir di bawah ini perlu kamu periksa sendiri.

## Kebutuhan

- [ ] Apakah pemakai sungguhan sudah ditanya? AI hanya mengerjakan apa yang diminta, dan tidak memikirkan hal yang lupa kamu minta.
- [ ] Apakah ada aturan tentang siapa yang boleh melihat data siapa?
- [ ] Apakah semua keadaan sudah punya tempat, termasuk yang tidak enak seperti "ditolak" beserta alasannya?

## Rancangan data

- [ ] Apakah tanggal dan waktu disimpan sebagai tipe waktu, bukan teks?
- [ ] Apakah pemilik data disimpan sebagai nomor id yang menunjuk ke tabel pengguna, bukan nama yang diketik bebas?
- [ ] Apakah riwayat disimpan sebagai baris baru, bukan satu kolom yang terus ditimpa?

## Query

- [ ] Apakah saringan tanggal memakai rentang, bukan `LIKE '%11%'`? Hitung hasilnya dengan tangan pada data contoh.
- [ ] Apakah index masih bisa dipakai oleh query itu?

## Login

- [ ] Apakah kata sandi di-hash dengan bcrypt atau argon2, bukan md5 atau sha1?
- [ ] Apakah input pengguna tidak pernah disambung langsung ke teks query (SQL injection)?
- [ ] Apakah percobaan login dibatasi?

## Upload berkas

- [ ] Apakah isi berkas diperiksa, bukan hanya nama atau ekstensinya?
- [ ] Apakah berkas disimpan di luar folder publik, dengan nama acak?
- [ ] Apakah berkas hanya bisa diambil oleh orang yang berhak?
- [ ] Apakah data lokasi (EXIF GPS) di foto sudah dibuang?

## Mengubah data

- [ ] Apakah hanya kolom yang memang boleh diubah yang diterima, bukan `$request->all()`?
- [ ] Apakah perubahan status mengikuti aturan alur, sehingga tidak ada langkah mundur?
- [ ] Apakah tercatat siapa mengubah apa, dan kapan?
- [ ] Apakah perubahan yang saling terkait disimpan dalam satu transaksi?

## Hak akses

- [ ] Coba ganti nomor di alamat, misalnya `/laporan/14` menjadi `/laporan/13`. Apakah data orang lain terbuka?
- [ ] Apakah pemeriksaan hak akses juga berlaku untuk berkas dan foto, bukan hanya halamannya?

## Tampilan

- [ ] Apakah data dari pengguna ditampilkan dengan `{{ }}`, bukan `{!! !!}` (XSS)?

## Server

- [ ] Apakah izin folder sudah secukupnya, bukan `chmod -R 777`?
- [ ] Apakah `APP_DEBUG=false` di server?
- [ ] Apakah berkas `.env` tidak ikut masuk ke Git?
- [ ] Apakah ada test otomatis yang menjaga aturan terpenting?
