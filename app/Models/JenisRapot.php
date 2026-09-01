<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JenisRapot extends Model
{
    protected $connection = 'mai1';

    protected $table = 'tjenisrapot';

    // kolom timestamp custom sesuai schema
    public const CREATED_AT = 'createat';
    public const UPDATED_AT = 'updateat';

    protected $fillable = [
        'nama',
        'semester',
        'aktif',
        'createby',
        'updateby',
    ];

    protected $casts = [
        'aktif' => 'boolean',
    ];

    public function rapors(): HasMany
    {
        return $this->hasMany(Rapor::class, 'idjenisrapot');
    }

    public function bobot(): HasMany
    {
        return $this->hasMany(BobotRapor::class, 'idjenisrapot');
    }

    // Scope query supaya controller/service tidak menulis where() manual berulang
    public function scopeAktif($query)
    {
        return $query->where('aktif', 1);
    }

    public function scopeSemester($query, string $semester)
    {
        return $query->where('semester', $semester);
    }
}