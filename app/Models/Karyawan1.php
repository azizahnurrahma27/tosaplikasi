<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Karyawan1 extends Model
{
    protected $connection = 'mai2';
    protected $table = 'tkaryawan1';
    protected $primaryKey = 'idk';

    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'idk',
        'stakar',
        'idjab',
        'tglmul',
        'barcod',
        'idcab',
        'iddiv',
        'idgra',
        'tipgaj',
        'bank',
        'norek',
        'lembur',
        'autosch',
    ];

    protected $casts = [
        'tglmul' => 'date',
    ];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'idk', 'Nik');
    }

    public function jabatan()
    {
        return $this->belongsTo(TJabatan::class, 'idjab', 'id');
    }
}