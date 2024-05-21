<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayaran';
    protected $primaryKey = 'id_pembayaran';

    protected $fillable = [
        'jenis_pembayaran',
        'bukti_pembayaran',
        'tanggal_pembayaran',
        'tanggal_pembayaran_valid',
        'total_pembayaran',
        'tip',
        'id_customer',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function transaksi()
    {
        return $this->hasOne(Transaksi::class, 'id_pembayaran', 'id_pembayaran');
    }
}
