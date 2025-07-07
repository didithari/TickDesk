<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Role extends Model
{

    public function alldata(){
        return DB::table('tb_role')->get();
    }

    use HasFactory;

    protected $table = 'tb_role';
    protected $primaryKey = 'idRole';
    public $timestamps = true;

    protected $fillable = ['namaRole'];
}
