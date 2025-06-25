<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivityLogController extends Controller
{

    // Menampilkan activity log
    public function index()
    {
        // Mengambil semua activity log
        $logs = ActivityLog::with('user')->orderBy('created_at', 'desc')->get();
        $lowStockItems = Barang::where('jumlah', '<=', 10)->get();
        $outOfStockItems = Barang::where('jumlah', 0)->get();
        $lowStockItems = $lowStockItems->filter(function ($item) use ($outOfStockItems) {
            // Menghapus barang yang sudah masuk dalam kategori stok habis
            return !$outOfStockItems->contains('id', $item->id);
        });
        return view('pemilik.activity-log', compact('logs','lowStockItems', 'outOfStockItems'));
    }
}
