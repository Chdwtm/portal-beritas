@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-3">{{ $berita->judul }}</h2>

    <p><strong>Kategori:</strong> {{ optional($berita->kategori)->nama ?? 'Tanpa Kategori' }}</p>
    <p><strong>Penulis:</strong> {{ optional($berita->penulis)->name ?? 'Tidak diketahui' }}</p>
    <p><strong>Tanggal:</strong> {{ $berita->created_at->format('d M Y') }}</p>
    <p><strong>Dilihat:</strong> {{ $berita->views }} kali</p>

    @if($berita->gambar)
    <img src="{{ asset('storage/' . $berita->gambar) }}" class="img-fluid mb-3 rounded" alt="{{ $berita->judul }}">
    @endif

    <p class="mt-3">{{ $berita->konten }}</p>

    <a href="{{ route('home') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>

    <hr>

    <!-- Komentar -->
    <h3>💬 Komentar ({{ $berita->komentars->count() }})</h3>

    @if(auth()->check())
    <form action="{{ route('berita.komentar', $berita->id) }}" method="POST">
        @csrf
        <textarea name="komentar" class="form-control" rows="3" placeholder="Tulis komentar..."></textarea>
        <button type="submit" class="btn btn-primary mt-2">Kirim</button>
    </form>
    @else
    <p><a href="{{ route('login') }}">Login</a> untuk berkomentar.</p>
    @endif

    <hr>

    @if(auth()->check())
    <form action="{{ route('berita.komentar', $berita->id) }}" method="POST">
        @csrf
        <textarea name="komentar" class="form-control" rows="3" placeholder="Tulis komentar..."></textarea>
        <button type="submit" class="btn btn-primary mt-2">Kirim</button>
    </form>
    @else
    <p><a href="{{ route('login') }}">Login</a> untuk berkomentar.</p>
    @endif


</div>
@endsection