<?php

namespace App\Http\Controllers;

use App\Models\JenisBarang;
use App\Models\Barang;
use Illuminate\Http\Request;
use App\Services\ActivityLogService;  // Import ActivityLogService

class JenisBarangController extends Controller
{
    protected $activityLogService;

    public function __construct(ActivityLogService $activityLogService)
    {
        $this->activityLogService = $activityLogService;
    }

    // Tampilkan semua jenis barang
    public function index()
    {
        $jenisBarangs = JenisBarang::all();
        $lowStockItems = Barang::where('jumlah', '<=', 10)->get();
        $outOfStockItems = Barang::where('jumlah', 0)->get();
        $lowStockItems = $lowStockItems->filter(function ($item) use ($outOfStockItems) {
            // Menghapus barang yang sudah masuk dalam kategori stok habis
            return !$outOfStockItems->contains('id', $item->id);
        });
        return view('admin.jenis-barang', compact('jenisBarangs','lowStockItems', 'outOfStockItems'));
    }

    // Simpan jenis barang baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_jenis' => 'required|string|unique:jenis_barangs,nama_jenis|max:255',
        ]);

        $jenisBarang = JenisBarang::create([
            'nama_jenis' => $request->nama_jenis,
        ]);

        // Menambahkan log aktivitas setelah data berhasil disimpan
        $this->activityLogService->logActivity('Create Jenis Barang', 'JenisBarang', $jenisBarang->toArray());

        return redirect()->route('jenis-barang')->with('success', 'Jenis barang berhasil ditambahkan.');
    }

    // Form tambah jenis barang
    public function create()
    {
        $lowStockItems = Barang::where('jumlah', '<=', 10)->get();
        $outOfStockItems = Barang::where('jumlah', 0)->get();
        $lowStockItems = $lowStockItems->filter(function ($item) use ($outOfStockItems) {
            // Menghapus barang yang sudah masuk dalam kategori stok habis
            return !$outOfStockItems->contains('id', $item->id);
        });
        return view('admin.jenis-barang-create', compact('lowStockItems', 'outOfStockItems'));
    }

    // Tampilkan form edit jenis barang
    public function edit($id)
    {
        $jenisBarang = JenisBarang::findOrFail($id);
        $lowStockItems = Barang::where('jumlah', '<=', 10)->get();
        $outOfStockItems = Barang::where('jumlah', 0)->get();
        $lowStockItems = $lowStockItems->filter(function ($item) use ($outOfStockItems) {
            // Menghapus barang yang sudah masuk dalam kategori stok habis
            return !$outOfStockItems->contains('id', $item->id);
        });
        return view('admin.jenis-barang-edit', compact('jenisBarang','lowStockItems', 'outOfStockItems'));
    }

    // Update jenis barang
    public function update(Request $request, $id)
    {
        $jenisBarang = JenisBarang::findOrFail($id);

        $request->validate([
            'nama_jenis' => 'required|string|max:255|unique:jenis_barangs,nama_jenis,' . $jenisBarang->id,
        ]);

        $jenisBarang->update([
            'nama_jenis' => $request->nama_jenis,
        ]);

        // Menambahkan log aktivitas setelah data berhasil diupdate
        $this->activityLogService->logActivity('Update Jenis Barang', 'JenisBarang', $jenisBarang->toArray());

        return redirect()->route('jenis-barang')->with('success', 'Jenis barang berhasil diupdate.');
    }

    // Hapus jenis barang
    public function destroy($id)
    {
        $jenisBarang = JenisBarang::findOrFail($id);

        // Menambahkan log aktivitas sebelum menghapus data
        $this->activityLogService->logActivity('Delete Jenis Barang', 'JenisBarang', $jenisBarang->toArray());

        // Hapus data jenis barang
        $jenisBarang->delete();

        return redirect()->route('jenis-barang')->with('success', 'Jenis barang berhasil dihapus.');
    }
}
