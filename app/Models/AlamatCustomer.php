<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlamatCustomer extends Model
{
    use HasFactory;

    protected $table = 'alamat_customers';

    protected $primaryKey = 'id_alamat';

    protected $fillable = [
        'label_alamat',
        'alamat',
        'id_customer'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
