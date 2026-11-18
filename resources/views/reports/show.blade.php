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
@endsection
