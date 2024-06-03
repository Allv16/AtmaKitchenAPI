<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Penitip extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'penitip';
    protected $primaryKey = 'id_penitip';

    protected $fillable = [
        'nama_penitip',
        'alamat_penitip',
        'telp_penitip',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function produk()
    {
        return $this->hasMany(Produk::class, 'id_penitip', 'id_penitip');
    }

    public function report($month, $year)
    {
        return $this->produk()
            ->whereHas('detailTransaksi', function ($query) use ($month, $year) {
                $query->whereHas('transaksi', function ($query) use ($month, $year) {
                    $query->whereYear('tanggal_nota_dibuat', $year)
                        ->whereMonth('tanggal_nota_dibuat', $month);
                });
            });
    }
}
