<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tnilai extends Model
{
    protected $connection = 'mai1';
    protected $table = 'tnilai';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $keyType = 'int';

    protected $fillable = [
        'idsis',
        'idkelas',
        'idpelajaran',
        'idguru',
        'idta',
        'idjenisnilai',
        'idtugas',
        'nilai',
    ];

    public function siswa()
    {
        return $this->belongsTo(Tsiswa::class, 'idsis', 'id');
    }

    public function kelas()
    {
        return $this->belongsTo(Tkelas::class, 'idkelas', 'id');
    }

    public function guru()
    {
        return $this->belongsTo(Tguru::class, 'idguru', 'id');
    }

    public function pelajaran()
    {
        return $this->belongsTo(Tpelajaran::class, 'idpelajaran', 'id');
    }

    public function jenisnilai()
    {
        return $this->belongsTo(TjenisNilai::class, 'idjenisnilai', 'id');
    }

    public function tugas()
    {
        return $this->belongsTo(Ttugas::class, 'idtugas', 'id');
    }

    public function tahunajaran()
    {
        return $this->belongsTo(Ttahunajaran::class, 'idta');
    }
}