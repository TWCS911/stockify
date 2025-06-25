<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\JenisBarang;
use Illuminate\Http\Request;
use App\Services\ActivityLogService;  // Import ActivityLogService

class BarangController extends Controller
{
    protected $activityLogService;

    public function __construct(ActivityLogService $activityLogService)
    {
        $this->activityLogService = $activityLogService;
    }

    // Tampilkan semua barang
    public function index()
    {
        $barangs = Barang::with(['jenisBarang'])->get();
        $lowStockItems = Barang::where('jumlah', '<=', 10)->get();
        $outOfStockItems = Barang::where('jumlah', 0)->get();
        $lowStockItems = $lowStockItems->filter(function ($item) use ($outOfStockItems) {
            // Menghapus barang yang sudah masuk dalam kategori stok habis
            return !$outOfStockItems->contains('id', $item->id);
        });
        return view('admin.data-barang', compact('barangs','lowStockItems','outOfStockItems'));
    }

    public function stok()
    {
        $barangs = Barang::with(['jenisBarang'])->get();
        $lowStockItems = Barang::where('jumlah', '<=', 10)->get();
        $outOfStockItems = Barang::where('jumlah', 0)->get();
        $lowStockItems = $lowStockItems->filter(function ($item) use ($outOfStockItems) {
            // Menghapus barang yang sudah masuk dalam kategori stok habis
            return !$outOfStockItems->contains('id', $item->id);
        });
        return view('admin.stok', compact('barangs','lowStockItems','outOfStockItems'));
    }

    public function stokpemilik()
    {
        $barangs = Barang::with(['jenisBarang'])->get();
        $lowStockItems = Barang::where('jumlah', '<=', 10)->get();
        $outOfStockItems = Barang::where('jumlah', 0)->get();
        $lowStockItems = $lowStockItems->filter(function ($item) use ($outOfStockItems) {
            // Menghapus barang yang sudah masuk dalam kategori stok habis
            return !$outOfStockItems->contains('id', $item->id);
        });
        return view('pemilik.stok', compact('barangs','lowStockItems','outOfStockItems'));
    }

    // Form tambah barang
    public function create()
    {
        $jenisBarangs = JenisBarang::all(); // Ambil semua jenis barang
        $satuanOptions = ['Pcs', 'Unit', 'Batang', 'Paket', 'Box', 'Set']; // Opsi satuan barang
        $lowStockItems = Barang::where('jumlah', '<=', 10)->get();
        $outOfStockItems = Barang::where('jumlah', 0)->get();
        $lowStockItems = $lowStockItems->filter(function ($item) use ($outOfStockItems) {
            // Menghapus barang yang sudah masuk dalam kategori stok habis
            return !$outOfStockItems->contains('id', $item->id);
        });
        return view('admin.data-barang-create', compact('jenisBarangs', 'satuanOptions','lowStockItems','outOfStockItems'));
    }

    // Simpan barang baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'jenis_barang_id' => 'required|exists:jenis_barangs,id',
            'satuan' => 'required|string',
        ]);

        // Cek apakah sudah ada data barang dengan kombinasi nama, jenis, dan satuan yang sama
        $exists = Barang::where('nama_barang', $request->nama_barang)
                        ->where('jenis_barang_id', $request->jenis_barang_id)
                        ->where('satuan', $request->satuan)
                        ->exists();

        if ($exists) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['nama_barang' => 'Barang dengan jenis dan satuan yang sama sudah ada.']);
        }

        $barang = Barang::create([
            'nama_barang' => $request->nama_barang,
            'jenis_barang_id' => $request->jenis_barang_id,
            'jumlah' => 0,
            'satuan' => $request->satuan,
        ]);

        // Menambahkan log aktivitas
        $this->activityLogService->logActivity('Create Barang', 'Barang', $barang->toArray());

        return redirect()->route('data-barang')->with('success', 'Barang berhasil ditambahkan.');
    }

    // Form edit barang
    public function edit($id)
    {
        $barang = Barang::findOrFail($id);
        $jenisBarangs = JenisBarang::all();
        $satuanOptions = ['Pcs', 'Unit', 'Batang', 'Paket', 'Box', 'Set'];
        $lowStockItems = Barang::where('jumlah', '<=', 10)->get();
        $outOfStockItems = Barang::where('jumlah', 0)->get();
        $lowStockItems = $lowStockItems->filter(function ($item) use ($outOfStockItems) {
            // Menghapus barang yang sudah masuk dalam kategori stok habis
            return !$outOfStockItems->contains('id', $item->id);
        });
        return view('admin.data-barang-edit', compact('barang', 'jenisBarangs', 'satuanOptions','lowStockItems','outOfStockItems'));
    }

    // Update barang
    public function update(Request $request, $id)
    {
        $barang = Barang::findOrFail($id);

        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'jenis_barang_id' => 'required|exists:jenis_barangs,id',
            'satuan' => 'required|string',
        ]);

        $barang->update([
            'nama_barang' => $request->nama_barang,
            'jenis_barang_id' => $request->jenis_barang_id,
            'satuan' => $request->satuan,
        ]);

        // Menambahkan log aktivitas
        $this->activityLogService->logActivity('Update Barang', 'Barang', $barang->toArray());

        return redirect()->route('data-barang')->with('success', 'Barang berhasil diupdate.');
    }

    // Hapus barang
    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);

        // Menambahkan log aktivitas
        $this->activityLogService->logActivity('Delete Barang', 'Barang', $barang->toArray());

        $barang->delete();

        return redirect()->route('data-barang')->with('success', 'Barang berhasil dihapus.');
    }
}
