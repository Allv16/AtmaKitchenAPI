<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Resep extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'resep';
    protected $primaryKey = 'id_resep';

    protected $fillable = [
        'jumlah_bahan',
        'id_produk',
        'id_bahan_baku',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id_produk');
    }

    public function bahanBaku()
    {
        return $this->belongsTo(BahanBaku::class, 'id_bahan_baku', 'id_bahan_baku');
    }
}
