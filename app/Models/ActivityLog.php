<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    protected $table = 'activity_logs'; // Nama tabel yang menyimpan log aktivitas

    protected $fillable = [
        'action',
        'model',
        'data',
        'user_id', // Menyimpan ID user yang melakukan aktivitas
    ];

    protected $casts = [
        'data' => 'array', // Menyimpan data dalam bentuk array
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
