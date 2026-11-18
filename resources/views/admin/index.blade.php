@extends('layouts.app')
@section('judul', 'Kelola laporan')
@section('isi')
<h1>Kelola laporan</h1>

<div class="rekap">
    @foreach (array_keys(App\Models\Report::ALUR) as $s)
        <a href="/kelola?status={{ $s }}" class="status {{ $s }}">{{ $s }} <b>{{ $rekap[$s] ?? 0 }}</b></a>
    @endforeach
</div>

<form class="kartu saring">
    <label>Tanggal <input type="date" name="tanggal" value="{{ $f['tanggal'] ?? '' }}"></label>
    <label>Bulan <input type="month" name="bulan" value="{{ $f['bulan'] ?? '' }}"></label>
    <label>Siswa
        <select name="siswa">
            <option value="">Semua</option>
            @foreach ($siswa as $w)
                <option value="{{ $w->id }}" @selected(($f['siswa'] ?? '') == $w->id)>{{ $w->name }} ({{ $w->classroom }})</option>
            @endforeach
        </select>
    </label>
    <label>Kategori
        <select name="kategori">
            <option value="">Semua</option>
            @foreach ($categories as $c)
                <option value="{{ $c->id }}" @selected(($f['kategori'] ?? '') == $c->id)>{{ $c->name }}</option>
            @endforeach
        </select>
    </label>
    <button class="tombol">Saring</button>
    <a class="redup" href="/kelola">Hapus saringan</a>
</form>

<p class="redup">{{ $reports->total() }} laporan</p>
@forelse ($reports as $r)
    <a class="kartu laporan" href="{{ route('laporan.show', $r) }}">
        <span class="status {{ $r->status }}">{{ $r->status }}</span>
        <b>{{ $r->title }}</b>
        <span class="redup">{{ $r->category->name }} · {{ $r->user->name }} ({{ $r->user->classroom }}) · {{ $r->created_at->translatedFormat('j F Y') }}</span>
    </a>
@empty
    <p class="kartu redup">Tidak ada laporan yang cocok.</p>
@endforelse

{{ $reports->links('halaman') }}
@endsection
