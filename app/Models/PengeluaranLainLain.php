<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PengeluaranLainLain extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pengeluaran_lain_lain';
    protected $primaryKey = 'id_pengeluaran_lain_lain';

    protected $fillable = [
        'nama_pengeluaran',
        'tanggal_pengeluaran',
        'total_pengeluaran',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
