<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\Barang;
use Illuminate\Http\Request;
use App\Services\ActivityLogService;  // Import ActivityLogService

class SupplierController extends Controller
{
    protected $activityLogService;

    public function __construct(ActivityLogService $activityLogService)
    {
        $this->activityLogService = $activityLogService;
    }

    // Tampilkan semua supplier
    public function index()
    {
        $suppliers = Supplier::all();
        $lowStockItems = Barang::where('jumlah', '<=', 10)->get();
        $outOfStockItems = Barang::where('jumlah', 0)->get();
        $lowStockItems = $lowStockItems->filter(function ($item) use ($outOfStockItems) {
            // Menghapus barang yang sudah masuk dalam kategori stok habis
            return !$outOfStockItems->contains('id', $item->id);
        });
        return view('admin.supplier', compact('suppliers','lowStockItems', 'outOfStockItems'));
    }

    // Form tambah supplier
    public function create()
    {
        $lowStockItems = Barang::where('jumlah', '<=', 10)->get();
        $outOfStockItems = Barang::where('jumlah', 0)->get();
        $lowStockItems = $lowStockItems->filter(function ($item) use ($outOfStockItems) {
            // Menghapus barang yang sudah masuk dalam kategori stok habis
            return !$outOfStockItems->contains('id', $item->id);
        });
        return view('admin.supplier-create', compact('lowStockItems', 'outOfStockItems'));
    }

    // Simpan supplier baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_supplier' => 'required|string|max:255',
            'alamat_supplier' => 'nullable|string',
            'no_telp_supplier' => 'nullable|string|max:20',
        ]);

        // Membuat supplier baru
        $supplier = Supplier::create($request->only(['nama_supplier', 'alamat_supplier', 'no_telp_supplier']));

        // Menambahkan log aktivitas untuk Create Supplier
        $this->activityLogService->logActivity('Create Supplier', 'Supplier', $supplier->toArray());

        return redirect()->route('suppliers.index')->with('success', 'Supplier berhasil ditambahkan.');
    }

    // Form edit supplier
    public function edit($id)
    {
        $supplier = Supplier::findOrFail($id);
        $lowStockItems = Barang::where('jumlah', '<=', 10)->get();
        $outOfStockItems = Barang::where('jumlah', 0)->get();
        $lowStockItems = $lowStockItems->filter(function ($item) use ($outOfStockItems) {
            // Menghapus barang yang sudah masuk dalam kategori stok habis
            return !$outOfStockItems->contains('id', $item->id);
        });
        return view('admin.supplier-edit', compact('supplier','lowStockItems', 'outOfStockItems'));
    }

    // Update supplier
    public function update(Request $request, $id)
    {
        $supplier = Supplier::findOrFail($id);

        $request->validate([
            'nama_supplier' => 'required|string|max:255',
            'alamat_supplier' => 'nullable|string',
            'no_telp_supplier' => 'nullable|string|max:20',
        ]);

        // Update supplier
        $supplier->update($request->only(['nama_supplier', 'alamat_supplier', 'no_telp_supplier']));

        // Menambahkan log aktivitas untuk Update Supplier
        $this->activityLogService->logActivity('Update Supplier', 'Supplier', $supplier->toArray());

        return redirect()->route('suppliers.index')->with('success', 'Supplier berhasil diupdate.');
    }

    // Hapus supplier
    public function destroy($id)
    {
        $supplier = Supplier::findOrFail($id);

        // Menambahkan log aktivitas untuk Delete Supplier
        $this->activityLogService->logActivity('Delete Supplier', 'Supplier', $supplier->toArray());

        // Hapus supplier
        $supplier->delete();

        return redirect()->route('suppliers.index')->with('success', 'Supplier berhasil dihapus.');
    }
}
