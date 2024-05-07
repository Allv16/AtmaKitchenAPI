<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class pembelianBahanBaku extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'pembelian_bahan_baku';
    protected $primaryKey = 'id_pembelian_bahan_baku';

    protected $fillable = [
        'tanggal_pembelian',
        'jumlah_pembelian',
        'harga_beli',
        'id_bahan_baku'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function bahan_baku()
    {
        return $this->belongsTo(BahanBaku::class, 'id_bahan_baku', 'id_bahan_baku');
    }
}
