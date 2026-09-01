<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ttugas extends Model
{
    protected $connection ='mai1';
    protected $table = 'ttugas';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $keyType = 'int';
protected $fillable = [
    'idkelas',
    'idguru',
    'idpelajaran',
    'mapel',
    'tglpenugasan',
    'tglpengumpulan',
    'judul',
    'deskripsi',
    'lampiran',
];

public function pelajaran()
{
    return $this->belongsTo(Tpelajaran::class, 'idpelajaran', 'id');
}

    public function details(){
        return $this->hasMany(Ttugas1::class,'idtugas','id');
    }

}
