<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PengembalianDana extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pengembalian_dana';
    protected $primaryKey = 'id_pengembalian_dana';

    protected $fillable = [
        'id_customer',
        'tanggal_pengembalian_diajukan',
        'tanggal_pengembalian_diterima',
        'jumlah_pengembalian',
        'nomor_rekening_tujuan',
        'status_pengembalian'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'id_customer', 'id_customer');
    }
}
