<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tcatatankasus extends Model
{
    protected $connection = 'mai1';
    protected $table = 'tcatatankasus';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $keyType = 'int';

    protected $fillable = [
        'idsis',
        'idkel',
        'idguru',
        'tanggal',
        'deskripsi_kasus',
        'jumlah_poin',
    ];

    public function siswa()
    {
        return $this->belongsTo(Tsiswa::class, 'idsis', 'id');
    }

    public function kelas()
    {
        return $this->belongsTo(Tkelas::class, 'idkel', 'id');
    }

    public function guru()
    {
        return $this->belongsTo(Karyawan::class, 'idguru', 'id');
    }
}