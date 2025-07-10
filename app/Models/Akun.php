<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Akun extends Model
{

    public function alldata(){
        return DB::table('tb_akun')->get();
    }

public function alldatad(){
    return DB::table('tb_akun')
        ->leftJoin('tb_role', 'tb_akun.idRole', '=', 'tb_role.idRole')
        ->where('tb_akun.lvlakun', '=', 1)
        ->select('tb_akun.*', 'tb_role.*')
        ->get();
}


    public function addData($data){
        return DB::table('tb_akun')->insert($data);
      }



    use HasFactory;

    protected $table = 'tb_akun';
    protected $primaryKey = 'username';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'username',
        'password',
        'name',
        'email',
        'nohp',
        'status',
        'lvlAkun',
        'imgProfile',
        'create_at',
        'updated_at',
        'idRole',
    ];
}
