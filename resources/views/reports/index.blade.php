@extends('layouts.app')
@section('judul', 'Laporan saya')
@section('isi')
<div class="baris-judul">
    <h1>Laporan saya</h1>
    <a class="tombol" href="/laporan/buat">+ Buat laporan</a>
</div>

@forelse ($reports as $r)
    <a class="kartu laporan" href="{{ route('laporan.show', $r) }}">
        <span class="status {{ $r->status }}">{{ $r->status }}</span>
        <b>{{ $r->title }}</b>
        <span class="redup">{{ $r->category->name }} · {{ $r->created_at->translatedFormat('j F Y') }}</span>
    </a>
@empty
    <p class="kartu redup">Belum ada laporan. Kalau ada sarana sekolah yang rusak, laporkan di sini.</p>
@endforelse

{{ $reports->links('halaman') }}
@endsection
