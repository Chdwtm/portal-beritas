@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4"><i class="fas fa-newspaper"></i> Kelola Berita</h2>

    <!-- Tombol Tambah Berita -->
    <a href="{{ route('admin.berita.create') }}" class="btn btn-primary mb-3">
        <i class="fas fa-plus"></i> Tambah Berita
    </a>

    <!-- Jika tidak ada berita -->
    @if($beritas->isEmpty())
    <div class="alert alert-warning text-center">
        <i class="fas fa-exclamation-circle"></i> Belum ada berita yang ditambahkan.
    </div>
    @else
    <!-- Tabel Daftar Berita -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-dark text-center">
                <tr>
                    <th>#</th>
                    <th>Judul</th>
                    <th>Kategori</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($beritas as $index => $berita)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $berita->judul }}</td>
                    <td class="text-center">{{ optional($berita->kategori)->nama ?? 'Tanpa Kategori' }}</td>
                    <td class="text-center">{{ $berita->created_at->format('d M Y') }}</td>
                    <td class="text-center">
                        <!-- Tombol Baca Selengkapnya -->
                        <a href="{{ route('admin.berita.show', $berita->id) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i> Lihat
                        </a>

                        <!-- Tombol Edit -->
                        <a href="{{ route('admin.berita.edit', $berita->id) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>

                        <!-- Tombol Hapus -->
                        <form action="{{ route('admin.berita.destroy', $berita->id) }}" method="POST"
                            style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"
                                onclick="return confirm('Hapus berita ini?')">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </form>
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
@endsection