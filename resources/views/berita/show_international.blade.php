@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-3">{{ $selectedNews['title'] ?? 'Judul Tidak Tersedia' }}</h2>
    <p><strong>Sumber:</strong> {{ $selectedNews['source']['name'] ?? 'Tidak diketahui' }}</p>
    <p><strong>Dipublikasikan:</strong> {{ \Carbon\Carbon::parse($selectedNews['publishedAt'])->format('d M Y') }}</p>

    @if(!empty($selectedNews['urlToImage']))
    <img src="{{ $selectedNews['urlToImage'] }}" class="img-fluid mb-3 rounded" alt="Gambar Berita">
    @endif

    <p class="mt-3">{{ $selectedNews['content'] ?? 'Konten tidak tersedia.' }}</p>

    <a href="{{ route('home') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>

    <!-- Kolom Komentar -->
    <h3 class="mt-5">💬 Komentar</h3>
    @if(auth()->check())
    <form action="{{ route('berita.komentar', ['berita' => $selectedNews['title']]) }}" method="POST">
        @csrf
        <textarea name="komentar" class="form-control" rows="3" placeholder="Tulis komentar..."></textarea>
        <button type="submit" class="btn btn-primary mt-2">Kirim</button>
    </form>
    @else
    <p><a href="{{ route('login') }}">Login</a> untuk berkomentar.</p>
    @endif

    <!-- Komentar -->
    <h4 class="mt-4">Komentar Pengguna</h4>
    <p class="text-muted">Fitur komentar untuk berita internasional akan segera tersedia.</p>
</div>
@endsection