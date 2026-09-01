<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tpelajaran extends Model
{
    protected $connection = 'mai1';
    protected $table = 'tpelajaran';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'tin',
        'idta',
        'nam',
        'jen',
        'idk',
        'ket',
        'sta',
        'rev',
        'createdat',
        'updatedat',
        'createdby',
        'updatedby',
    ];

    protected $casts = [
        'createdat' => 'datetime',
        'updatedat' => 'datetime',
    ];

    

    public function guruMengajar()
    {
        return $this->hasMany(TguruMengajar::class, 'idpelajaran', 'id');
    }
}
