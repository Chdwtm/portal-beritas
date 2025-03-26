@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4"><i class="fas fa-newspaper"></i> Berita Lokal</h2>

    <div class="row">
        @foreach ($beritas as $berita)
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                @if($berita->gambar)
                <img src="{{ asset('storage/' . $berita->gambar) }}" class="card-img-top" alt="{{ $berita->judul }}">
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{ $berita->judul }}</h5>
                    <p class="text-muted"><small>{{ $berita->created_at->format('d M Y') }} -
                            {{ optional($berita->kategori)->nama ?? 'Tanpa Kategori' }}</small></p>
                    <p class="card-text">{{ Str::limit($berita->konten, 100) }}</p>
                    <a href="{{ route('berita.show', ['berita' => $berita->id]) }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-book-open"></i> Baca Selengkapnya
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $beritas->links() }}
    </div>

    <hr>

    <!-- Berita dari News API -->
    <h2 class="mb-4"><i class="fas fa-globe"></i> Berita Internasional</h2>
    <div class="row">
        @foreach ($newsFromAPI as $news)
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                @if(isset($news['urlToImage']))
                <img src="{{ $news['urlToImage'] }}" class="card-img-top" alt="{{ $news['title'] }}">
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{ $news['title'] }}</h5>
                    <p class="text-muted"><small>{{ $news['publishedAt'] }}</small></p>
                    <p class="card-text">{{ Str::limit($news['description'], 100) }}</p>
                    <a href="{{ $news['url'] }}" class="btn btn-info btn-sm" target="_blank">
                        <i class="fas fa-external-link-alt"></i> Baca Selengkapnya
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection