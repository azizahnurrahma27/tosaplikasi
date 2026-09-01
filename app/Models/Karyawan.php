<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Karyawan extends Model
{
    protected $connection = 'mai2';
    protected $table = 'tkaryawan';
    protected $primaryKey = 'Nip';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'nip',
        'nam',
        'tin',
        'ala',
        'jenkel',
        'temlah',
        'tgllah',
        'tel',
        'nohp',
        'ket',
        'jab',
        'tglinp',
        'sta',
        'staabs',
        'useid',
        'pass',
    ];

    protected $hidden = [
        'Pass',
    ];

    protected $casts = [
        'TglLah' => 'date',
        'TglInp' => 'date',
        'Sta' => 'integer',
        'StaAbs' => 'integer',
    ];

    public function scopeAktif($query)
    {
        return $query->where('Sta', 1);
    }

    public function detail()
    {
        return $this->hasOne(Karyawan1::class, 'idk', 'Nip');
    }

    public function administrasi()
    {
        return $this->hasOne(Karyawan2::class, 'idk', 'Nip');
    }
}