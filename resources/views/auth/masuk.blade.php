@extends('layouts.app')
@section('judul', 'Masuk')
@section('isi')
<form method="POST" action="/masuk" class="kartu sempit">
    @csrf
    <h1>Masuk</h1>
    <label>Email
        <input type="email" name="email" value="{{ old('email') }}" required autofocus>
    </label>
    <label>Kata sandi
        <input type="password" name="password" required>
    </label>
    <button class="tombol">Masuk</button>
    <p class="redup">Siswa baru? <a href="/daftar">Daftar di sini</a></p>
</form>
@endsection
