<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PresensiKaryawan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'presensi_karyawan';
    protected $primaryKey = 'id_presensi_karyawan';

    protected $fillable = [
        'tanggal_absen',
        'id_karyawan',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan', 'id_karyawan');
    }
}
