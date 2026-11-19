@extends('layouts.app')
@section('judul', $report->title)
@section('isi')
<a class="redup" href="/">← Kembali</a>

<article class="kartu">
    <span class="status {{ $report->status }}">{{ $report->status }}</span>
    <h1>{{ $report->title }}</h1>
    <p class="redup">{{ $report->category->name }} · {{ $report->location }} · dilaporkan {{ $report->user->name }} ({{ $report->user->classroom }})</p>
    <p>{{ $report->description }}</p>
    @if ($report->photo)
        <img class="foto" src="{{ route('laporan.foto', $report) }}" alt="Foto laporan">
    @endif
</article>

<h2>Riwayat</h2>
<ol class="riwayat">
    @foreach ($report->updates as $u)
        <li>
            <span class="status {{ $u->status }}">{{ $u->status }}</span>
            <span class="redup">{{ $u->created_at->translatedFormat('j F Y, H.i') }} · {{ $u->user->name }}</span>
            <p>{{ $u->note }}</p>
            @if ($u->photo)
                <img class="foto" src="{{ route('riwayat.foto', $u) }}" alt="Foto progres">
            @endif
        </li>
    @endforeach
</ol>

@if (auth()->user()->isAdmin())
    <form method="POST" action="{{ route('kelola.tanggapi', $report) }}" enctype="multipart/form-data" class="kartu">
        @csrf
        <h2>Tanggapi</h2>
        <label>Status
            <select name="status">
                <option value="{{ $report->status }}">Tetap {{ $report->status }}</option>
                @foreach (App\Models\Report::ALUR[$report->status] as $s)
                    <option value="{{ $s }}">Ubah menjadi {{ $s }}</option>
                @endforeach
            </select>
        </label>
        <label>Umpan balik untuk siswa
            <textarea name="note" rows="3" required>{{ old('note') }}</textarea>
        </label>
        <label>Foto progres (boleh dikosongkan)
            <input type="file" name="photo" accept="image/jpeg,image/png">
        </label>
        <button class="tombol">Simpan tanggapan</button>
    </form>
@endif
@endsection
