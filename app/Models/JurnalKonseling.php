<?php

namespace App\Models;

use App\Models\Karyawan;
use App\Models\Tsiswa;
use App\Models\Tkelas;
use App\Models\Tta;
use Illuminate\Database\Eloquent\Model;

class JurnalKonseling extends Model
{
    protected $connection = 'mai1';
    protected $table = 'tjurnalkonseling';
    protected $primaryKey = 'id';

    public $timestamps = true;

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $fillable = [
        'idsis',
        'idkar',
        'idkel',
        'idta',
        'tanggal',
        'waktu_mulai',
        'waktu_selesai',
        'deskripsi_kegiatan',
        'rencana_tindak_lanjut',
    ];

    protected $casts = [
        'tanggal'       => 'date',
        'waktu_mulai'   => 'datetime:H:i:s',
        'waktu_selesai' => 'datetime:H:i:s',
    ];

    public function siswa()
    {
        return $this->belongsTo(Tsiswa::class, 'idsis', 'id');
    }

    public function guru()
    {
        return $this->belongsTo(Karyawan::class, 'idkar', 'Nip');
    }

    public function kelas()
    {
        return $this->belongsTo(Tkelas::class, 'idkel', 'id');
    }

    public function tahunAjaran()
    {
        return $this->belongsTo(Ttahunajaran::class, 'idta', 'id');
    }
}