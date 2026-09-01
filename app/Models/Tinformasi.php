<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tinformasi extends Model
{
    protected $connection = 'mai1';
    protected $table = 'tinformasi';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $keyType = 'int';

    protected $fillable = [
        'idkel',
        'tanggal',
        'info',
        'deskripsi',
        'file_pendukung',
        'tin'
    ];

    protected $casts = [
       'tanggal' => 'date',
   ];

    public function kelas()
    {
        return $this->belongsTo(Tkelas::class, 'idkel', 'id');
    }
}