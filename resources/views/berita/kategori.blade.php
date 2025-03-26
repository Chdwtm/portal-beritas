@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Berita Kategori: {{ $kategori->nama }}</h2>

    @foreach ($beritas as $berita)
    <h3><a href="{{ route('berita.show', $berita->id) }}">{{ $berita->judul }}</a></h3>
    <p>{{ Str::limit($berita->konten, 150) }}</p>
    @endforeach

    {{ $beritas->links() }}
</div>
@endsection