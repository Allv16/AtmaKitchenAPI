<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AlamatCustomer extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'alamat_customers';

    protected $primaryKey = 'id_alamat';

    protected $fillable = [
        'label_alamat',
        'alamat',
        'id_customer'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
