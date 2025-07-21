<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Model
{
    use HasFactory;

    protected $table = 'users'; // tabel baru
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'username',
        'password',
        'name',
        'email',
        'phone_number',
        'privLevel',
        'profile_picture',
        'devRoleID',
        'created_at',
        'updated_at',
    ];

    // === Manual Query: all data dengan role (khusus admin)
    public function alldatad()
    {
        return DB::table('users')
            ->leftJoin('devRoles', 'users.devRoleID', '=', 'devRoles.id')
            ->where('users.privLevel', '=', 'developer')
            ->select('users.*', 'devRoles.roleName as nameRole')
            ->get();
    }

    // === Tanpa filter level akun
    public function alldata()
    {
        return DB::table('users')
            ->leftJoin('devRoles', 'users.devRoleID', '=', 'devRoles.id')
            ->select('users.*', 'devRoles.roleName')
            ->get();
    }

    public function addData($data)
    {
        return DB::table('users')->insert($data);
    }
}
