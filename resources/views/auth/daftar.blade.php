@extends('layouts.app')
@section('judul', 'Daftar')
@section('isi')
<form method="POST" action="/daftar" class="kartu sempit">
    @csrf
    <h1>Daftar siswa</h1>
    <label>Nama
        <input name="name" value="{{ old('name') }}" required>
    </label>
    <label>Kelas
        <input name="classroom" value="{{ old('classroom') }}" placeholder="XI RPL 2" required>
    </label>
    <label>Email
        <input type="email" name="email" value="{{ old('email') }}" required>
    </label>
    <label>Kata sandi (minimal 8 karakter)
        <input type="password" name="password" required>
    </label>
    <label>Ulangi kata sandi
        <input type="password" name="password_confirmation" required>
    </label>
    <button class="tombol">Daftar</button>
    <p class="redup">Sudah punya akun? <a href="/masuk">Masuk</a></p>
</form>
@endsection
