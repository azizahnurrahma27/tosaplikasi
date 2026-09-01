<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ttingkat extends Model
{
    protected $connection = 'mai2';
    
    protected $table = 'ttingkat';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'nam',
        'kod',
        'maxlev',
        'nextin',
        'ket',
        'sta',
        'createdat',
        'updatedat',
        'createdby',
        'updatedby',
    ];

    const CREATED_AT = 'createdat';
    const UPDATED_AT = 'updatedat';

    public function tingkat1(): HasMany
    {
        return $this->hasMany(Ttingkat1::class, 'tin', 'id');
    }

    public function akunGuru()
    {
        return $this->hasMany(Takunguru::class, 'tin', 'id');
    }
}