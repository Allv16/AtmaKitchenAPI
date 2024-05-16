<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';

    protected $primaryKey = 'id_transaksi';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'id_transaksi',
        'tanggal_nota_dibuat',
        'tanggal_diterima',
        'tanggal_diproses',
        'tanggal_ditolak',
        'tanggal_siap',
        'tanggal_ambil',
        'tanggal_selesai',
        'tanggal_diambil',
        'poin_digunakan',
        'poin_diperoleh',
        'total',
        'jenis_pengiriman',
        'status_transaksi',
        'id_customer',
        'id_pembayaran',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class, 'id_transaksi', 'id_transaksi');
    }

    public function pembayaran()
    {
        return $this->belongsTo(Pembayaran::class, 'id_pembayaran', 'id_pembayaran');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'id_customer', 'id_customer');
    }

    public function pengiriman()
    {
        return $this->hasOne(Pengiriman::class, 'id_transaksi', 'id_transaksi');
    }
}
