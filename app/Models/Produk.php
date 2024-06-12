<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

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
        $dateInput = Carbon::parse($date);
        $twoDaysFromNow = Carbon::now()->addDays(1);
        if ($this->id_penitip != null) {
            $totalSold = $this->detailTransaksi()
                ->whereHas('transaksi', function ($query) use ($date) {
                    $query->where('status_transaksi', '!=', 'Rejected')->orWhere('status_transaksi', '!=', 'Cancelled');
                })
                ->sum('jumlah_item');
        } else {
            if ($dateInput->greaterThan($twoDaysFromNow)) {
                if ($this->jenis_produk == 'Cake') {
                    $productName = $this->nama_produk;
                    if (Str::contains($this->nama_produk, '1/2')) {
                        $productName = Str::before($this->nama_produk, ' (1/2 loyang)');
                    }
                    $totalSold =
                        DetailTransaksi::whereHas('produk', function ($query) use ($productName) {
                            $query->where('nama_produk', 'like', $productName . '%');
                        })->whereHas('transaksi', function ($query) use ($date) {
                            $query->whereDate('tanggal_ambil', $date);
                            $query->where('status_transaksi', '!=', 'rejected');
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
                            $query->whereDate('tanggal_ambil', $date);
                            $query->where('status_transaksi', '!=', 'rejected');
                        })
                        ->sum('jumlah_item');
                }
            } else {
                $productName = $this->nama_produk;
                if (Str::contains($this->nama_produk, '1/2')) {
                    $totalSold =
                        DetailTransaksi::whereHas('produk', function ($query) use ($productName) {
                            $query->where('nama_produk', $productName);
                        })->whereHas('transaksi', function ($query) use ($date) {
                            $query->whereDate('tanggal_ambil', $date);
                            $query->where('status_transaksi', '!=', 'rejected');
                        })->get()->sum(function ($detailTransaksi) {
                            return $detailTransaksi->jumlah_item;
                        });
                    if ($totalSold != 1) {
                        $totalSold = $this->limit_produksi;
                    } else {
                        $totalSold =
                            $this->limit_produksi - 1;
                    }
                } else {
                    $totalSold = $this->limit_produksi;
                }
            }
        }
        $stock = $this->limit_produksi - $totalSold;

        return $stock;
    }

    public function resep()
    {
        return $this->hasMany(Resep::class, 'id_produk', 'id_produk')->with('bahanBaku');
    }
}
