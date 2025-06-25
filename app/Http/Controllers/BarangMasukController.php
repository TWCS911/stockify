<?php

namespace App\Http\Controllers;

use App\Models\BarangMasuk;
use App\Models\Barang;
use App\Models\Supplier;
use App\Models\BarangKeluar;
use Illuminate\Http\Request;
use App\Services\ActivityLogService;  // Pastikan untuk mengimport ActivityLogService
use Barryvdh\DomPDF\Facade\Pdf as PDF; // Import PDF facade

class BarangMasukController extends Controller
{
    protected $activityLogService;

    public function __construct(ActivityLogService $activityLogService)
    {
        $this->activityLogService = $activityLogService;
    }

    public function index()
    {
        $barangMasuks = BarangMasuk::with(['barang.jenisBarang', 'supplier'])->get();
        $lowStockItems = Barang::where('jumlah', '<=', 10)->get();
        $outOfStockItems = Barang::where('jumlah', 0)->get();
        $lowStockItems = $lowStockItems->filter(function ($item) use ($outOfStockItems) {
            // Menghapus barang yang sudah masuk dalam kategori stok habis
            return !$outOfStockItems->contains('id', $item->id);
        });
        return view('admin.barang-masuk', compact('barangMasuks','lowStockItems','outOfStockItems'));
    }

    public function create()
    {
        $barangs = Barang::all();
        $suppliers = Supplier::all();
        $lowStockItems = Barang::where('jumlah', '<=', 10)->get();
        $outOfStockItems = Barang::where('jumlah', 0)->get();
        $lowStockItems = $lowStockItems->filter(function ($item) use ($outOfStockItems) {
            // Menghapus barang yang sudah masuk dalam kategori stok habis
            
            return !$outOfStockItems->contains('id', $item->id);
        });
        return view('admin.barang-masuk-create', compact('barangs', 'suppliers','lowStockItems','outOfStockItems'));
    }
    
    public function store(Request $request)
    {
        // dd($request->all()); 
        // Validasi
        $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'supplier_id' => 'required|exists:suppliers,id_supplier',
            'jumlah' => 'required|integer|min:1',
            'tanggal_masuk' => 'required|date_format:d/m/Y', // Validasi format tanggal
        ]);

        // Mengonversi tanggal dari format dd/mm/yyyy ke format Y-m-d yang dapat diterima oleh database
        $tanggalMasuk = \Carbon\Carbon::createFromFormat('d/m/Y', $request->tanggal_masuk)->format('Y-m-d');

        // Membuat Barang Masuk
        $barangMasuk = BarangMasuk::create([
            'barang_id' => $request->barang_id,
            'supplier_id' => $request->supplier_id,
            'jumlah' => $request->jumlah,
            'tanggal_masuk' => $tanggalMasuk, // Menyimpan tanggal dalam format Y-m-d
        ]);

        // Update stok barang
        $barang = Barang::findOrFail($request->barang_id);
        $barang->jumlah += $request->jumlah;
        $barang->save();

        return redirect()->route('barang-masuk.index')->with('success', 'Data barang masuk berhasil disimpan dan stok diperbarui.');
    }



    public function laporanFormBarangMasuk()
    {
        $lowStockItems = Barang::where('jumlah', '<=', 10)->get();
        $outOfStockItems = Barang::where('jumlah', 0)->get();
        $lowStockItems = $lowStockItems->filter(function ($item) use ($outOfStockItems) {
            // Menghapus barang yang sudah masuk dalam kategori stok habis
            return !$outOfStockItems->contains('id', $item->id);
        });
        return view('pemilik.LaporanBarang', compact('lowStockItems', 'outOfStockItems')); 
    }

    public function generateLaporan(Request $request)
    {
        // Validasi input
        $request->validate([
            'jenis_laporan' => 'required|in:barang-masuk,barang-keluar',
            'bulan' => 'required|date_format:m',
            'tahun' => 'required|date_format:Y',
        ]);

        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $jenisLaporan = $request->jenis_laporan;

        // Ambil data berdasarkan jenis laporan yang dipilih
        if ($jenisLaporan == 'barang-masuk') {
            $barangMasuks = BarangMasuk::whereYear('tanggal_masuk', $tahun)
                ->whereMonth('tanggal_masuk', $bulan)
                ->with(['barang', 'supplier']) // Jika Anda ingin menampilkan supplier
                ->get();

            // Generate PDF
            $pdf = PDF::loadView('pemilik.barang-masuk-laporan-pdf', compact('barangMasuks', 'bulan', 'tahun'));
        } else {
            $barangKeluars = BarangKeluar::whereYear('tanggal_keluar', $tahun)
                ->whereMonth('tanggal_keluar', $bulan)
                ->with(['barang'])
                ->get();

            // Generate PDF
            $pdf = PDF::loadView('pemilik.barang-keluar-laporan-pdf', compact('barangKeluars', 'bulan', 'tahun'));
        }

        // Download PDF
        return $pdf->download('Laporan_' . ucfirst($jenisLaporan) . "_{$bulan}_{$tahun}.pdf");
    }



    public function edit($id)
    {
        $barangMasuk = BarangMasuk::findOrFail($id);
        $barangs = Barang::all();
        $suppliers = Supplier::all();
        $lowStockItems = Barang::where('jumlah', '<=', 10)->get();
        $outOfStockItems = Barang::where('jumlah', 0)->get();
        $lowStockItems = $lowStockItems->filter(function ($item) use ($outOfStockItems) {
            // Menghapus barang yang sudah masuk dalam kategori stok habis
            return !$outOfStockItems->contains('id', $item->id);
        });
        return view('admin.barang-masuk-edit', compact('barangMasuk', 'barangs', 'suppliers','lowStockItems','outOfStockItems'));
    }

    public function update(Request $request, $id)
{
    // Validasi data
    $request->validate([
        'barang_id' => 'required|exists:barangs,id', // Pastikan barang_id ada di tabel barangs
        'jumlah' => 'required|integer|min:1',
        'supplier_id' => 'required|exists:suppliers,id_supplier',
        'tanggal_masuk' => 'required|date_format:d/m/Y', // Validasi format tanggal
    ]);

    // Mengonversi tanggal dari format d/m/Y ke format Y-m-d
    $tanggalMasuk = \Carbon\Carbon::createFromFormat('d/m/Y', $request->tanggal_masuk)->format('Y-m-d');

    // Menemukan Barang Masuk berdasarkan ID
    $barangMasuk = BarangMasuk::findOrFail($id);
    $barangLama = $barangMasuk->barang; // Barang lama yang sebelumnya dipilih

    // Jika barang yang dipilih pada update berbeda dengan yang lama, kembalikan stok barang lama
    if ($barangLama->id != $request->barang_id) {
        // Mengembalikan stok barang lama yang sebelumnya berkurang
        $barangLama->jumlah -= $barangMasuk->jumlah;
        $barangLama->save();
    }

    // Ambil data barang baru yang dipilih
    $barangBaru = Barang::findOrFail($request->barang_id);

    // Cek apakah stok cukup di barang baru
    if ($request->jumlah > $barangBaru->jumlah) {
        return back()->withErrors(['jumlah' => 'Jumlah masuk tidak boleh melebihi stok yang tersedia.']);
    }

    // Update data barang masuk dengan data yang baru
    $barangMasuk->update([
        'barang_id' => $request->barang_id,
        'supplier_id' => $request->supplier_id,
        'jumlah' => $request->jumlah,
        'tanggal_masuk' => $tanggalMasuk, // Menyimpan tanggal masuk
    ]);

    // Kurangi stok barang baru setelah update
    $barangBaru->jumlah += $request->jumlah; // Menambah stok barang baru sesuai jumlah
    $barangBaru->save();

    // Menambahkan log aktivitas
    $this->activityLogService->logActivity('Update Barang Masuk', 'BarangMasuk', $barangMasuk->toArray());

    return redirect()->route('barang-masuk.index')->with('success', 'Barang masuk berhasil diperbarui dan stok diperbarui.');
}



    public function destroy($id)
    {
        $barangMasuk = BarangMasuk::findOrFail($id);

        // Menambahkan log aktivitas
        $this->activityLogService->logActivity('Delete Barang Masuk', 'BarangMasuk', $barangMasuk->toArray());

        // Hapus data Barang Masuk
        $barangMasuk->delete();

        return redirect()->route('barang-masuk.index')->with('success', 'Data barang masuk berhasil dihapus.');
    }
}
