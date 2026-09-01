<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BobotRapor extends Model
{
    protected $connection = 'mai1';

    protected $table = 'tbobotrapor';

    public const CREATED_AT = 'createat';
    public const UPDATED_AT = 'updateat';

    protected $fillable = [
        'idjenisrapot',
        'idjenisnilai',
        'bobot',
        'createby',
        'updateby',
    ];

    protected $casts = [
        'bobot' => 'decimal:2',
    ];

    public function jenisRapot(): BelongsTo
    {
        return $this->belongsTo(JenisRapot::class, 'idjenisrapot');
    }

    // NOTE: sesuaikan dengan Model JenisNilai kalau sudah ada di project kamu
    public function jenisNilai(): BelongsTo
    {
        return $this->belongsTo(TjenisNilai::class, 'idjenisnilai');
    }
}