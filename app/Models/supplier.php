<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_supplier';

    public $incrementing = false;  // Karena id_supplier berupa string dengan prefix

    protected $keyType = 'string';

    protected $fillable = [
        'id_supplier',
        'nama_supplier',
        'alamat_supplier',
        'no_telp_supplier',
    ];

    /**
     * Boot method untuk generate id_supplier otomatis saat creating
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id_supplier)) {
                $last = self::orderBy('id_supplier', 'desc')->first();

                if ($last) {
                    // Ambil angka terakhir dari id_supplier
                    $lastNumber = (int) str_replace('SUP-', '', $last->id_supplier);
                    $newNumber = $lastNumber + 1;
                } else {
                    $newNumber = 1;
                }

                $model->id_supplier = 'SUP-' . str_pad($newNumber, 7, '0', STR_PAD_LEFT);
            }
        });
    }

    // Relasi ke BarangMasuk (One to Many)
    public function barangMasuks()
    {
        return $this->hasMany(BarangMasuk::class, 'supplier_id', 'id_supplier');
    }

    // Relasi ke BarangKeluar (One to Many)
    public function barangKeluars()
    {
        return $this->hasMany(BarangKeluar::class, 'supplier_id', 'id_supplier');
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }
}
