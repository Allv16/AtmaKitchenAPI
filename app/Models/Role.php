<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $table = 'roles';
    protected $primaryKey = 'id_role';
    protected $fillable = ['nama_role'];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
