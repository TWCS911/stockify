<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    // protected $table = 'barangs';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $keyType = 'int';

    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'jenis_barang_id',
        'jumlah',
        'satuan',
    ];

    // Relasi ke JenisBarang (Many to One)
    public function jenisBarang()
    {
        return $this->belongsTo(JenisBarang::class, 'jenis_barang_id');
    }


    // Relasi ke BarangMasuk (One to Many)
    public function barangMasuks()
    {
        return $this->hasMany(BarangMasuk::class, 'barang_id');
    }

    // Relasi ke BarangKeluar (One to Many)
    public function barangKeluars()
    {
        return $this->hasMany(BarangKeluar::class, 'barang_id');
    }

    

    /**
     * Boot method untuk generate kode_barang otomatis saat creating
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Generate kode_barang otomatis dengan format BAR-0000001, BAR-0000002, dst
            if (empty($model->kode_barang)) {
                $last = self::orderBy('id', 'desc')->first();

                if ($last) {
                    // Ambil angka terakhir dari kode_barang
                    $lastNumber = (int) str_replace('BAR-', '', $last->kode_barang);
                    $newNumber = $lastNumber + 1;
                } else {
                    $newNumber = 1;
                }

                $model->kode_barang = 'BAR-' . str_pad($newNumber, 7, '0', STR_PAD_LEFT);
            }
        });
    }
}
