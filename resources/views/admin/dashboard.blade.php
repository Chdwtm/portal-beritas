@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Dashboard Admin</h2>

    <!-- Tombol Tambah Berita -->
    <a href="{{ route('admin.berita.create') }}" class="btn btn-primary mb-3">Tambah Berita</a>

    <!-- Daftar Berita -->
    <h3>Daftar Berita</h3>

    @if($beritas->isEmpty())
    <p class="alert alert-warning">Belum ada berita.</p>
    @else
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Judul</th>
                <th>Kategori</th>
                <th>Penulis</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($beritas as $index => $berita)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $berita->judul }}</td>
                <td>{{ optional($berita->kategori)->nama ?? 'Tanpa Kategori' }}</td>
                <td>{{ optional($berita->penulis)->name ?? 'Tanpa Penulis' }}</td>
                <td>{{ $berita->created_at->format('d M Y') }}</td>
                <td>
                    <!-- Tombol Lihat -->
                    <a href="{{ route('berita.show', $berita->id) }}" class="btn btn-info btn-sm">Lihat</a>

                    <!-- Tombol Edit -->
                    <a href="{{ route('admin.berita.edit', $berita->id) }}" class="btn btn-warning btn-sm">Edit</a>

                    <!-- Tombol Hapus -->
                    <form action="{{ route('admin.berita.destroy', $berita->id) }}" method="POST"
                        style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm"
                            onclick="return confirm('Hapus berita ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    <!-- Pagination -->
    {{ $beritas->links() }}
</div>
@endsection