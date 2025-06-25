<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangMasuk extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    public $incrementing = false; // Karena ID string
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'barang_id',
        'supplier_id',
        'jumlah',
        'tanggal_masuk', // Menambahkan kolom tanggal_masuk ke dalam fillable
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $last = self::orderBy('id', 'desc')->first();

                if ($last) {
                    $lastNumber = (int) str_replace('TRM-', '', $last->id);
                    $newNumber = $lastNumber + 1;
                } else {
                    $newNumber = 1;
                }

                $model->id = 'TRM-' . str_pad($newNumber, 7, '0', STR_PAD_LEFT);
            }
        });
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }

    // Relasi ke Supplier
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id_supplier');
    }

    public function jenisBarang()
    {
        return $this->belongsTo(JenisBarang::class, 'jenis_barang_id');
    }
}
