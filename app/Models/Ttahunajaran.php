<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ttahunajaran extends Model
{
    protected $connection = 'mai1';
    protected $table = 'ttahunajaran';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $keyType = 'int';
    protected $fillable = [
        'id',
        'nam',
        'idpre',
        'tglmul',
        'tglsel',
        'ket',
        'sta',
        'staakt',
        'rev'
    ];

    public function kelas()
    {
        return $this->hasMany(Tkelas::class, 'idta', 'id');
    }

    public function guruMengajar()
{
    return $this->hasMany(Tgurumengajar::class, 'idta', 'id');
}


}
