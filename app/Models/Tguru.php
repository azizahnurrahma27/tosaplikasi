<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Tguru extends Model
{
    protected $table = 'tguru';

    protected $fillable = [
        'nip', 'namaguru', 'jeniskelamin', 'alamat', 'nohp', 'email',
    ];

    public function akun(): HasOne
    {
        return $this->hasOne(Takunguru::class, 'idguru');
    }

    public function mengajar(): HasMany
    {
        return $this->hasMany(Tgurumengajar::class, 'idguru');
    }
}