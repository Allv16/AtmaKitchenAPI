<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BahanBaku extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'bahan_baku';
    protected $primaryKey = 'id_bahan_baku';

    protected $fillable = [
        'nama_bahan_baku',
        'stok',
        'satuan',
        'min_stok'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function resep()
    {
        return $this->hasMany(Resep::class, 'id_bahan_baku', 'id_bahan_baku');
    }
}
