<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TjenisNilai extends Model
{
    protected $connection = 'mai1';
    protected $table = 'tjenisnilai';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $keyType = 'int';

    protected $fillable = [
        'nama',
        'tipe'
    ];

    public function nilai()
    {
        return $this->hasMany(Tnilai::class, 'idjenisnilai', 'id');
    }
}