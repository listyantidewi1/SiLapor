<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('judul', 'SiLapor') · SMK Nusa Bakti</title>
    <link rel="stylesheet" href="/css/gaya.css">
</head>
<body>
    <header class="atas">
        <a class="merek" href="/">Si<b>Lapor</b> <span>SMK Nusa Bakti</span></a>
        @auth
            <form method="POST" action="/keluar">
                @csrf
                <span class="siapa">{{ auth()->user()->name }}</span>
                <button class="tautan">Keluar</button>
            </form>
        @endauth
    </header>
    <main>
        @if (session('pesan'))
            <p class="pesan">{{ session('pesan') }}</p>
        @endif
        @if ($errors->any())
            <ul class="galat">
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        @endif
        @yield('isi')
    </main>
</body>
</html>
