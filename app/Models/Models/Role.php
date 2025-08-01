<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $table = 'tb_role';
    protected $primaryKey = 'idRole';
    public $timestamps = true;

    protected $fillable = ['namaRole'];
}
