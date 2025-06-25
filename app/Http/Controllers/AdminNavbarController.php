<?php
namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use App\Models\ActivityLog;

class AdminNavbarController extends Controller
{
    public function showNavbar()
    {
        // Mengambil data untuk pemberitahuan stok barang habis
        $lowStockItems = Barang::where('jumlah', '<=', 0)->get();
        return view('layouts.navbar', compact('lowStockItems'));
    }
}
