<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\MutasiSaldo;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customers';

    protected $primaryKey = 'id_customer';

    protected $fillable = [
        'id_user',
        'nama_customer',
        'no_telp',
        'tanggal_lahir',
        'email',
        'jenis_kelamin',
        'poin'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function saldo()
    {
        return $this->hasOne(MutasiSaldo::class, 'id_customer', 'id_customer')->latest();
    }
}
