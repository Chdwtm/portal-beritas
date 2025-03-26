<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Kategori;
use App\Models\Komentar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class BeritaController extends Controller
{
    // **Menampilkan berita di halaman utama (Lokal + API)**
    public function index()
    {
        // Ambil berita dari database
        $beritas = Berita::with('kategori')->latest()->paginate(5);

        // Ambil berita dari News API (Internasional)
        $newsFromAPI = $this->getNewsFromAPI();

        return view('berita.index', compact('beritas', 'newsFromAPI'));
    }

    // **Menampilkan berita di dashboard pengguna (Populer, Terbaru, API)**
    public function dashboard()
{
    // Ambil berita dari database (terbaru)
    $beritas = Berita::with('kategori')->latest()->paginate(5);

    // Berita populer berdasarkan jumlah views
    $beritaPopuler = Berita::with('kategori')
        ->orderBy('views', 'desc')
        ->limit(5)
        ->get();

    // Ambil berita dari News API (Internasional)
    $newsFromAPI = $this->getNewsFromAPI();

    return view('dashboard', compact('beritas', 'beritaPopuler', 'newsFromAPI'));
}



    // **Menampilkan berita di dashboard admin**
    public function adminIndex()
    {
        $beritas = Berita::with('kategori', 'penulis')->latest()->paginate(10);
        return view('admin.berita.index', compact('beritas'));
    }

    // **Menampilkan berita berdasarkan kategori**
    public function kategori(Kategori $kategori)
    {
        $beritas = Berita::where('kategori_id', $kategori->id)->latest()->paginate(10);
        return view('berita.kategori', compact('beritas', 'kategori'));
    }

    // **Menampilkan berita secara lengkap & komentar**
    public function show(Berita $berita)
    {
        $berita->increment('views');
        $komentars = $berita->komentars()->latest()->get();
        return view('berita.show', compact('berita', 'komentars'));
    }

    public function showInternationalNews($id)
{
    // Ambil data berita dari News API berdasarkan ID
    $newsFromAPI = $this->getNewsFromAPI();
    $selectedNews = $newsFromAPI[$id] ?? null;

    if (!$selectedNews) {
        return redirect()->route('home')->with('error', 'Berita tidak ditemukan.');
    }

    return view('berita.show_international', compact('selectedNews'));
}


    // **Form tambah berita**
    public function create()
    {
        $kategoris = Kategori::all();
        return view('admin.berita.create', compact('kategoris'));
    }

    // **Menyimpan berita yang ditambahkan admin**
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id',
            'konten' => 'required',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $gambarPath = $request->file('gambar') ? $request->file('gambar')->store('berita', 'public') : null;

        Berita::create([
            'judul' => $request->judul,
            'kategori_id' => $request->kategori_id,
            'konten' => $request->konten,
            'gambar' => $gambarPath,
            'penulis_id' => auth()->id(),
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Berita berhasil ditambahkan!');
    }

    // **Menampilkan form edit berita**
    public function edit(Berita $berita)
    {
        $kategoris = Kategori::all();
        return view('admin.berita.edit', compact('berita', 'kategoris'));
    }

    // **Menyimpan perubahan berita**
    public function update(Request $request, Berita $berita)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id',
            'konten' => 'required',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            if ($berita->gambar) {
                Storage::delete('public/' . $berita->gambar);
            }
            $gambarPath = $request->file('gambar')->store('berita', 'public');
        } else {
            $gambarPath = $berita->gambar;
        }

        $berita->update([
            'judul' => $request->judul,
            'kategori_id' => $request->kategori_id,
            'konten' => $request->konten,
            'gambar' => $gambarPath,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Berita berhasil diperbarui!');
    }

    // **Menghapus berita**
    public function destroy(Berita $berita)
    {
        if ($berita->gambar) {
            Storage::delete('public/' . $berita->gambar);
        }
        $berita->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Berita berhasil dihapus!');
    }

    // **Menambahkan komentar ke berita**
    public function tambahKomentar(Request $request, Berita $berita)
    {
        $request->validate([
            'komentar' => 'required|string|max:1000',
        ]);

        Komentar::create([
            'berita_id' => $berita->id,
            'user_id' => auth()->id(),
            'komentar' => $request->komentar,
        ]);

        return back()->with('success', 'Komentar berhasil ditambahkan!');
    }

    // **Fitur Pencarian Berita**
    public function search(Request $request)
    {
        $keyword = $request->input('q');

        $beritas = Berita::where('judul', 'LIKE', "%$keyword%")
                          ->orWhere('konten', 'LIKE', "%$keyword%")
                          ->latest()
                          ->paginate(10);

        return view('berita.search', compact('beritas', 'keyword'));
    }

    // **Fungsi untuk mengambil berita dari API (Internasional)**
    public function getNewsFromAPI()
{
    $apiKey = env('NEWS_API_KEY', '4898d2d0d6de49ef9b2931f7a0f3c95e'); 
    $url = "https://newsapi.org/v2/top-headlines?language=en&apiKey={$apiKey}";

    try {
        $response = Http::timeout(5)->get($url); // Timeout untuk menghindari error

        if ($response->successful()) {
            $data = $response->json();
            return array_slice($data['articles'] ?? [], 0, 10); // Ambil 10 berita terbaru
        } else {
            return []; 
        }
    } catch (\Exception $e) {
        return [];
    }
}

}