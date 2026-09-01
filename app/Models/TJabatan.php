<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TJabatan extends Model
{
    protected $connection = 'mai2';
    protected $table = 'tjabatan';
    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'kod',
        'nam',
        'ket',
        'sta',
        'createdat',
        'updatedat',
    ];

    protected $casts = [
        'sta' => 'integer',
        'createdat' => 'datetime',
        'updatedat' => 'datetime',
    ];

    public function karyawanDetails()
    {
        return $this->hasMany(Karyawan1::class, 'idjab', 'id');
    }
}