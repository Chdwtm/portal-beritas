@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Hasil Pencarian: "{{ $keyword }}"</h2>

    @if($beritas->isEmpty())
    <p class="alert alert-warning">Tidak ada berita yang cocok dengan pencarian.</p>
    @else
    @foreach ($beritas as $berita)
    <div class="card my-3">
        <div class="card-body">
            <h4>{{ $berita->judul }}</h4>
            <p>{{ Str::limit($berita->konten, 150) }}</p>
            <a href="{{ route('berita.show', $berita->id) }}" class="btn btn-primary btn-sm">Baca Selengkapnya</a>
        </div>
    </div>
    @endforeach

    {{ $beritas->links() }}
    @endif
</div>
@endsection