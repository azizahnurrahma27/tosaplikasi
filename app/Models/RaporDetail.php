<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RaporDetail extends Model
{
    protected $connection = 'mai1';

    protected $table = 'trapor_detail';

    public const CREATED_AT = 'createat';
    public const UPDATED_AT = 'updateat';

    protected $fillable = [
        'idrapor',
        'idpelajaran',
        'nilai',
        'predikat',
        'deskripsi',
        'createby',
        'updateby',
    ];

    protected $casts = [
        'nilai' => 'decimal:2',
    ];

    public function rapor(): BelongsTo
    {
        return $this->belongsTo(Rapor::class, 'idrapor');
    }

    // NOTE: sesuaikan dengan Model Pelajaran yang sudah ada di project kamu
    public function pelajaran(): BelongsTo
    {
        return $this->belongsTo(Tpelajaran::class, 'idpelajaran');
    }
}