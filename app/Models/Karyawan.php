<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Karyawan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'karyawan';
    protected $primaryKey = 'id_karyawan';

    protected $fillable = [
        'nama_karyawan',
        'gaji_karyawan',
        'bonus_gaji_karyawan',
        'gaji_karyawan',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function presensiKaryawan()
    {
        return $this->hasMany(PresensiKaryawan::class, 'id_karyawan', 'id_karyawan');
    }
}
