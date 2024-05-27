<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MutasiSaldo extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'mutasi_saldo';
    protected $primaryKey = 'id_mutasi_saldo';
    protected $fillable = [
        'id_customer',
        'debit',
        'kredit',
        'saldo',
        'tanggal_mutasi'
    ];

    protected $hidden = [
        'updated_at',
        'deleted_at'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'id_customer', 'id_customer');
    }
}
