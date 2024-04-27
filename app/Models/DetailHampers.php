<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailHampers extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'detail_hampers';
    protected $primaryKey = 'id_detail_hampers';

    protected $fillable = [
        'id_hampers',
        'id_produk',
        'id_kemasan',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function items()
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id_produk');
    }
    public function hampers()
    {
        return $this->belongsTo(Produk::class, 'id_hampers', 'id_produk');
    }
}
