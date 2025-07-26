<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SupportTicket extends Model
{
    use HasFactory;

    protected $table = 'devTickets';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'supportID',
        'devID',
        'roleID',
        'title',
        'status',
        'link',
        'created_at',
        'updated_at',
    ];

    // Ambil semua data devTickets
    public function allData()
    {
        return DB::table($this->table)->get();
    }

    // Ambil data dengan join ke user support dan developer
    public function allWithUsers()
    {
        return DB::table($this->table)
            ->leftJoin('users as support', 'devTickets.supportID', '=', 'support.id')
            ->leftJoin('users as dev', 'devTickets.devID', '=', 'dev.id')
            ->select('devTickets.*', 'support.name as support_name', 'dev.name as dev_name')
            ->get();
    }

    // Model SupportTicket
    public function allWithDevRole()
    {
        return DB::table($this->table)
            ->leftJoin('devRoles', 'devTickets.roleID', '=', 'devRoles.id')
            ->leftJoin('users as support', 'devTickets.supportID', '=', 'support.id') // Join dengan tabel users untuk support
            ->select('devTickets.*', 'devRoles.roleName', 'support.name as support_name') // Tambahkan support_name
            ->get();
    }



    // Tambah data
    public function addData($data)
    {
        return DB::table($this->table)->insert($data);
    }
}
