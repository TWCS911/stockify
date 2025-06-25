<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangKeluar extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    public $incrementing = false; // karena id ada prefix
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'barang_id',
        'tanggal_keluar',
        'jumlah_keluar',
        'penjual',
        'pembeli',
        'no_telp',
        'tujuan',
        'tanggal_keluar',
    ];

    // Relasi ke Barang
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }

    public function jenisBarang()
    {
        return $this->belongsTo(JenisBarang::class, 'jenis_barang_id');
    }

    


    /**
     * Boot method untuk generate ID transaksi otomatis saat creating
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $last = self::orderBy('id', 'desc')->first();

                if ($last) {
                    // Ambil angka terakhir dari id
                    $lastNumber = (int) str_replace('TRK-', '', $last->id);
                    $newNumber = $lastNumber + 1;
                } else {
                    $newNumber = 1;
                }

                $model->id = 'TRK-' . str_pad($newNumber, 7, '0', STR_PAD_LEFT);
            }
        });
    }
}

