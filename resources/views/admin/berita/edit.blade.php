<form action="{{ route('admin.berita.update', ['berita' => $berita->id]) }}" method="POST"
    enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label for="judul" class="form-label">Judul Berita</label>
        <input type="text" class="form-control" name="judul" value="{{ $berita->judul }}" required>
    </div>

    <div class="mb-3">
        <label for="kategori_id" class="form-label">Kategori</label>
        <select class="form-control" name="kategori_id">
            @foreach ($kategoris as $kategori)
            <option value="{{ $kategori->id }}" {{ $berita->kategori_id == $kategori->id ? 'selected' : '' }}>
                {{ $kategori->nama }}
            </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="konten" class="form-label">Isi Berita</label>
        <textarea class="form-control" name="konten" rows="5">{{ $berita->konten }}</textarea>
    </div>

    <div class="mb-3">
        <label for="gambar" class="form-label">Gambar</label>
        <input type="file" class="form-control" name="gambar">
    </div>

    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
</form>