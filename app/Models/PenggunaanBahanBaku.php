<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PenggunaanBahanBaku extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'penggunaan_bahan_baku';
    protected $primaryKey = 'id_penggunaan_bahan_baku';
    protected $fillable = [
        'id_bahan_baku',
        'jumlah_penggunaan',
        'tanggal_penggunaan'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function bahanBaku()
    {
        return $this->belongsTo(BahanBaku::class, 'id_bahan_baku', 'id_bahan_baku');
    }
}
