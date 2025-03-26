@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">📰 Berita Lokal</h2>

    @foreach ($beritas as $berita)
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">{{ $berita->judul }}</h5>
            <p class="card-text">{{ Str::limit($berita->konten, 100) }}</p>
            <a href="{{ route('berita.show', $berita->id) }}" class="btn btn-primary">Baca Selengkapnya</a>
        </div>
    </div>
    @endforeach

    <h2 class="mt-5 mb-4">🌍 Berita Internasional</h2>

    @if (!empty($newsFromAPI))
    <div class="row">
        @foreach ($newsFromAPI as $news)
        <div class="col-md-6 mb-3">
            <div class="card h-100">
                @if(!empty($news['urlToImage']))
                <img src="{{ $news['urlToImage'] }}" class="card-img-top fixed-image" alt="Gambar Berita">
                @else
                <img src="{{ asset('images/default-news.jpg') }}" class="card-img-top fixed-image" alt="Gambar Default">
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{ $news['title'] ?? 'Judul Tidak Tersedia' }}</h5>
                    <p class="card-text">{{ Str::limit($news['description'] ?? 'Tidak ada deskripsi.', 100) }}</p>
                    <a href="{{ route('berita.international.show', ['id' => $loop->index]) }}" class="btn btn-info">
                        Baca Selengkapnya
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <p class="alert alert-warning">Tidak ada berita dari API.</p>
    @endif
</div>
@endsection