<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SatuanBarang extends Model
{
    use HasFactory;

    // protected $table = 'satuan_barangs';

    protected $primaryKey = 'id';

    protected $fillable = [
        'nama_satuan',
    ];

    /**
     * Relasi ke barang (jika satuan barang ini punya banyak barang)
     */
}
