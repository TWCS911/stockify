<?php

namespace App\Http\Controllers;

use App\Models\BarangKeluar;
use App\Models\Barang;
use App\Models\SatuanBarang;
use Illuminate\Http\Request;
use App\Services\ActivityLogService;  // Import ActivityLogService

class BarangKeluarController extends Controller
{
    protected $activityLogService;

    public function __construct(ActivityLogService $activityLogService)
    {
        $this->activityLogService = $activityLogService;
    }

    // Tampilkan semua barang keluar
    public function index()
    {
        $barangKeluars = BarangKeluar::with(['barang', 'jenisBarang'])->get();
        $lowStockItems = Barang::where('jumlah', '<=', 10)->get();
        $outOfStockItems = Barang::where('jumlah', 0)->get();
        $lowStockItems = $lowStockItems->filter(function ($item) use ($outOfStockItems) {
            // Menghapus barang yang sudah masuk dalam kategori stok habis
            return !$outOfStockItems->contains('id', $item->id);
        });
        return view('admin.barang-keluar', compact('barangKeluars','lowStockItems','outOfStockItems'));
    }

    // Tampilkan form tambah barang keluar
    public function create()
    {
        $barangs = Barang::all();
        $satuanBarangs = SatuanBarang::all();
        $lowStockItems = Barang::where('jumlah', '<=', 10)->get();
        $outOfStockItems = Barang::where('jumlah', 0)->get();
        $lowStockItems = $lowStockItems->filter(function ($item) use ($outOfStockItems) {
            // Menghapus barang yang sudah masuk dalam kategori stok habis
            return !$outOfStockItems->contains('id', $item->id);
        });
        return view('admin.barang-keluar-create', compact('barangs', 'satuanBarangs','lowStockItems','outOfStockItems'));
    }

    // Simpan data barang keluar
    public function store(Request $request)
    {
        // Validasi data yang diterima dari form
        $request->validate([
            'barang_id' => 'required|exists:barangs,id',  // Pastikan barang_id ada di tabel barangs
            'jumlah_keluar' => 'required|integer|min:1',  // Jumlah keluar harus lebih dari 0
            'penjual' => 'required|string|max:255',  // Admin penjual wajib diisi
            'pembeli' => 'required|string|max:255',  // Pembeli wajib diisi
            'no_telp' => 'required|string|max:255',  // No Telp wajib diisi
            'tujuan' => 'required|string|max:255',  // Tujuan wajib diisi
            'tanggal_keluar' => 'required|date_format:d-m-Y', // Validasi format tanggal
        ]);

        // Mengonversi tanggal dari format d-m-Y ke format Y-m-d
        $tanggalKeluar = \Carbon\Carbon::createFromFormat('d-m-Y', $request->tanggal_keluar)->format('Y-m-d');

        // Ambil data barang berdasarkan barang_id
        $barang = Barang::findOrFail($request->barang_id);

        // Cek apakah stok cukup
        if ($request->jumlah_keluar > $barang->jumlah) {
            return back()->withErrors(['jumlah_keluar' => 'Jumlah keluar tidak boleh melebihi stok yang tersedia.']);
        }

        // Persiapkan data untuk disimpan, pastikan hanya data yang dibutuhkan yang disertakan
        $data = $request->only(['barang_id', 'jumlah_keluar', 'penjual', 'pembeli', 'no_telp', 'tujuan']);
        $data['tanggal_keluar'] = $tanggalKeluar; // Menyimpan tanggal dalam format Y-m-d

        // Simpan data barang keluar
        $barangKeluar = BarangKeluar::create($data);

        // Kurangi stok barang setelah barang keluar disimpan
        $barang->jumlah -= $request->jumlah_keluar;
        $barang->save();

        // Menambahkan log aktivitas
        $this->activityLogService->logActivity('Create Barang Keluar', 'BarangKeluar', $barangKeluar->toArray());

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('barang-keluar.index')->with('success', 'Data barang keluar berhasil disimpan dan stok diperbarui.');
    }


    // Tampilkan form edit barang keluar
    public function edit($id)
    {
        $barangKeluar = BarangKeluar::findOrFail($id);
        $barangs = Barang::all();
        $satuanBarangs = SatuanBarang::all();
        $lowStockItems = Barang::where('jumlah', '<=', 10)->get();
        $outOfStockItems = Barang::where('jumlah', 0)->get();
        $lowStockItems = $lowStockItems->filter(function ($item) use ($outOfStockItems) {
            // Menghapus barang yang sudah masuk dalam kategori stok habis
            return !$outOfStockItems->contains('id', $item->id);
        });
        return view('admin.barang-keluar-edit', compact('barangKeluar', 'barangs', 'satuanBarangs','lowStockItems','outOfStockItems'));
    }

    // Update barang keluar
    public function update(Request $request, $id)
    {
        // Validasi data
        $request->validate([
            'barang_id' => 'required|exists:barangs,id', // Pastikan barang_id ada di tabel barangs
            'jumlah_keluar' => 'required|integer|min:1',
            'penjual' => 'required|string|max:255',
            'pembeli' => 'required|string|max:255',
            'no_telp' => 'required|string|max:255',
            'tujuan' => 'required|string|max:255',
            'tanggal_keluar' => 'required|date_format:d-m-Y', // Validasi format tanggal
        ]);

        // Mengonversi tanggal dari format d-m-Y ke format Y-m-d
        $tanggalKeluar = \Carbon\Carbon::createFromFormat('d-m-Y', $request->tanggal_keluar)->format('Y-m-d');

        // Menemukan Barang Keluar berdasarkan ID
        $barangKeluar = BarangKeluar::findOrFail($id);
        $barangLama = $barangKeluar->barang; // Barang lama yang sebelumnya dipilih

        // Jika barang yang dipilih pada update berbeda dengan yang lama, kembalikan stok barang lama
        if ($barangLama->id != $request->barang_id) {
            // Kembalikan stok barang lama
            $barangLama->jumlah += $barangKeluar->jumlah_keluar;
            $barangLama->save();
        }

        // Ambil data barang baru yang dipilih
        $barangBaru = Barang::findOrFail($request->barang_id);

        // Cek apakah stok cukup di barang baru
        if ($request->jumlah_keluar > $barangBaru->jumlah) {
            return back()->withErrors(['jumlah_keluar' => 'Jumlah keluar tidak boleh melebihi stok yang tersedia.']);
        }

        // Update data barang keluar dengan data yang baru
        $barangKeluar->update([
            'barang_id' => $request->barang_id,
            'jumlah_keluar' => $request->jumlah_keluar,
            'penjual' => $request->penjual,
            'pembeli' => $request->pembeli,
            'no_telp' => $request->no_telp,
            'tujuan' => $request->tujuan,
            'tanggal_keluar' => $tanggalKeluar, // Menyimpan tanggal keluar
        ]);

        // Kurangi stok barang baru setelah update
        $barangBaru->jumlah -= $request->jumlah_keluar;
        $barangBaru->save();

        // Menambahkan log aktivitas
        $this->activityLogService->logActivity('Update Barang Keluar', 'BarangKeluar', $barangKeluar->toArray());

        return redirect()->route('barang-keluar.index')->with('success', 'Barang keluar berhasil diperbarui dan stok diperbarui.');
    }
    


    // Hapus barang keluar
    public function destroy($id)
    {
        $barangKeluar = BarangKeluar::findOrFail($id);

        // Menambahkan log aktivitas
        $this->activityLogService->logActivity('Delete Barang Keluar', 'BarangKeluar', $barangKeluar->toArray());

        // Hapus data Barang Keluar
        $barangKeluar->delete();

        return redirect()->route('barang-keluar.index')->with('success', 'Barang keluar berhasil dihapus.');
    }
}
