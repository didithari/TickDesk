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

    public function alldatad()
{
    return DB::table('tb_akun')
        ->leftJoin('tb_role', 'tb_akun.idRole', '=', 'tb_role.idRole')
        ->select('tb_akun.*', 'tb_role.*') // ambil semua kolom dari kedua tabel
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
        'status',
        'lvlAkun',
        'imgProfile',
        'idRole',
    ];
}
