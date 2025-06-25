<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class OwnerDashboardController extends Controller
{
    public function index()
    {
        // Mengambil total stok barang, barang masuk, barang keluar
        $totalStok = Barang::sum('jumlah'); // Total stok barang
        $barangMasuk = BarangMasuk::count(); // Total transaksi barang masuk
        $barangKeluar = BarangKeluar::count(); // Total transaksi barang keluar
        $activityLogs = ActivityLog::count(); // Total aktivitas log
        $lowStockItems = Barang::where('jumlah', '<=', 10)->get();
        $outOfStockItems = Barang::where('jumlah', 0)->get();
        $lowStockItems = $lowStockItems->filter(function ($item) use ($outOfStockItems) {
            // Menghapus barang yang sudah masuk dalam kategori stok habis
            return !$outOfStockItems->contains('id', $item->id);
        });


        return view('pemilik.dashboard', compact('totalStok', 'barangMasuk', 'barangKeluar', 'activityLogs','lowStockItems','outOfStockItems'));
    }

    public function getDashboardData()
    {
        // Mengambil total stok barang, barang masuk, barang keluar
        $totalStok = Barang::sum('jumlah'); // Total stok barang
        $barangMasuk = BarangMasuk::count(); // Total transaksi barang masuk
        $barangKeluar = BarangKeluar::count(); // Total transaksi barang keluar
        $activityLogs = ActivityLog::count(); // Total aktivitas log

        // Ambil data stok habis dan stok rendah
        $lowStockItems = Barang::where('jumlah', '<=', 10)->get();
        $outOfStockItems = Barang::where('jumlah', 0)->get();

        // Filter barang yang sudah habis
        $lowStockItems = $lowStockItems->filter(function ($item) use ($outOfStockItems) {
            return !$outOfStockItems->contains('id', $item->id);
        });

        // Ambil data barang masuk per bulan
        $barangMasukPerBulan = BarangMasuk::selectRaw('MONTH(created_at) as month, count(*) as count')
                                          ->groupBy('month')
                                          ->pluck('count', 'month')->toArray();

        // Ambil data barang keluar per bulan
        $barangKeluarPerBulan = BarangKeluar::selectRaw('MONTH(created_at) as month, count(*) as count')
                                            ->groupBy('month')
                                            ->pluck('count', 'month')->toArray();

        // Kembalikan data sebagai JSON
        return response()->json([
            'totalStok' => $totalStok,
            'barangMasuk' => $barangMasuk,
            'barangKeluar' => $barangKeluar,
            'activityLogs' => $activityLogs,
            'lowStockItems' => $lowStockItems,
            'outOfStockItems' => $outOfStockItems,
            'barangMasukPerBulan' => $barangMasukPerBulan,
            'barangKeluarPerBulan' => $barangKeluarPerBulan,
        ]);
    }
}

