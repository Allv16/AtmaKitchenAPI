<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Produk extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'produk';
    protected $primaryKey = 'id_produk';

    protected $fillable = [
        'nama_produk',
        'harga',
        'limit_produksi',
        'jenis_produk',
        'id_penitip',
        'deskripsi',
        'foto'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function penitip()
    {
        return $this->belongsTo(Penitip::class, 'id_penitip', 'id_penitip');
    }

    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class, 'id_produk', 'id_produk');
    }

    public function detailHampers()
    {
        return $this->hasMany(DetailHampers::class, 'id_hampers', 'id_produk');
    }

    public function stok($date)
    {
        $totalSold = 0;
        if ($this->jenis_produk == 'Cake') {
            $productName = $this->nama_produk;
            if (Str::contains($this->nama_produk, '1/2')) {
                $productName = Str::before($this->nama_produk, ' (1/2 loyang)');
            }
            $totalSold =
                DetailTransaksi::whereHas('produk', function ($query) use ($productName) {
                    $query->where('nama_produk', 'like', $productName . '%');
                })->whereHas('transaksi', function ($query) use ($date) {
                    $query->whereDate('tanggal_nota_dibuat', $date);
                })->get()->sum(function ($detailTransaksi) {
                    if (!Str::contains($detailTransaksi->produk->nama_produk, '1/2')) {
                        return $detailTransaksi->jumlah_item * 2;
                    } else {
                        return $detailTransaksi->jumlah_item;
                    }
                });
            if (!Str::contains($this->nama_produk, '1/2')) {
                $totalSold = ceil($totalSold / 2);
            }
        } else {
            $totalSold = $this->detailTransaksi()
                ->whereHas('transaksi', function ($query) use ($date) {
                    $query->whereDate('tanggal_nota_dibuat', $date);
                })
                ->sum('jumlah_item');
        }
        $stock = $this->limit_produksi - $totalSold;

        return $stock;
    }
}
