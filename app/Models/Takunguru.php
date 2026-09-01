<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;

class Takunguru extends Model implements Authenticatable
{
    use AuthenticatableTrait, Authorizable;

    protected $table = 'takunguru';

    protected $fillable = [
        'idguru',
        'username',
        'password',
        'tin',
    ];

    public function tingkat(): BelongsTo
    {
        return $this->belongsTo(Ttingkat::class, 'tin', 'id');
    }
    public function guru(): BelongsTo
    {
        return $this->belongsTo(Karyawan::class, 'idguru', 'id');
    }

    public function getAuthIdentifierName(): string
    {
        return 'id';
    }

    public function getAuthIdentifier()
    {
        return $this->id;
    }

    public function getAuthPasswordName(): string
    {
        return 'password';
    }

    public function getAuthPassword()
    {
        return $this->password;
    }
}