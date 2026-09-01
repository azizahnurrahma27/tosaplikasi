<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Karyawan2 extends Model
{
    protected $connection = 'mai2';
    protected $table = 'tkaryawan2';
    protected $primaryKey = 'idk';

    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'idk',
        'ktp',
        'npwp',
        'jamsos',
        'bpjs',
    ];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'idk', 'Nik');
    }
}