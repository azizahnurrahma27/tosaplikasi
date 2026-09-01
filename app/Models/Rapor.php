<?php

namespace App\Models;

use App\Models\JenisRapot;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Rapor extends Model
{
    protected $connection = 'mai1';
    protected $table = 'trapor';

    public const CREATED_AT = 'createat';
    public const UPDATED_AT = 'updateat';

    protected $fillable = [
        'idsiswa',
        'idkelas',
        'idta',
        'idjenisrapot',
        'tanggal',
        'deskripsi',
        'lampiran',
        'createby',
        'updateby',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    // --- Relasi ---
    // NOTE: sesuaikan nama Model Siswa/Kelas/TahunAjaran dengan yang sudah ada di project kamu.
    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Tsiswa::class, 'idsiswa');
    }

    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Tkelas::class, 'idkelas');
    }

    public function tahunAjaran(): BelongsTo
    {
        return $this->belongsTo(TtahunAjaran::class, 'idta');
    }

    public function jenisRapot(): BelongsTo
    {
        return $this->belongsTo(JenisRapot::class, 'idjenisrapot');
    }

    public function detail(): HasMany
    {
        return $this->hasMany(RaporDetail::class, 'idrapor');
    }
}