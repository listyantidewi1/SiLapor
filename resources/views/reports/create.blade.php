@extends('layouts.app')
@section('judul', 'Buat laporan')
@section('isi')
<form method="POST" action="/laporan" enctype="multipart/form-data" class="kartu">
    @csrf
    <h1>Buat laporan</h1>
    <label>Kategori
        <select name="category_id" required>
            <option value="">Pilih kategori</option>
            @foreach ($categories as $c)
                <option value="{{ $c->id }}" @selected(old('category_id') == $c->id)>{{ $c->name }}</option>
            @endforeach
        </select>
    </label>
    <label>Judul singkat
        <input name="title" value="{{ old('title') }}" maxlength="100" placeholder="Proyektor tidak menyala" required>
    </label>
    <label>Lokasi
        <input name="location" value="{{ old('location') }}" maxlength="100" placeholder="Depan XI RPL 2" required>
    </label>
    <label>Ceritakan masalahnya
        <textarea name="description" rows="4" required>{{ old('description') }}</textarea>
    </label>
    <label>Foto (boleh dikosongkan, maksimal 4 MB)
        <input type="file" name="photo" accept="image/jpeg,image/png">
    </label>
    <button class="tombol">Kirim laporan</button>
</form>
@endsection
