<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisBarang extends Model
{
    use HasFactory;

    // protected $table = 'jenis_barangs';

    // Primary key (default 'id')
    protected $primaryKey = 'id';

    protected $fillable = [
        'nama_jenis'
    ];

    /**
     * Relasi ke barang
     */
    public function barangs()
    {
        return $this->hasMany(Barang::class, 'jenis_barang_id');
    }
}