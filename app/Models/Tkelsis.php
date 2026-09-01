<?php

namespace App\Models;

use App\Models\Tkelas;
use Illuminate\Database\Eloquent\Model;

class Tkelsis extends Model
{
    protected   $connection = 'mai1';

    protected $primaryKey = 'tin';
    protected   $table      = 'tkelsis';
    protected   $keyType    = 'int';
    public      $timestamps =  false;
    protected   $fillable   = [
        'idta',
        'ids',
        'idkel',
        'sta',
        'createdat',
        'updatedat',
        'createdby',
        'updatedby',
    ];

public function siswa()
{
    return $this->belongsTo(Tsiswa::class,'ids','id');
}

    public function detailsiswa()
    {
        return $this->belongsTo(Tsiswa1::class,'ids','ids');
    }

    public function kelas()
    {
        return $this->belongsTo(Tkelas::class,'idkel','id');
    }

    public function detail()
    {
        return $this->hasMany(Tkelsis1::class,'idkel','idkel');    
    }

    public function tingkat()
    {
        return $this->belongsTo(Ttingkat::class,'tin','id');
    }


    public function tahunajaran()
    {
        return $this->belongsTo(Ttahunajaran::class, 'idta', 'id')->where('staakt', 1);

    }
}
