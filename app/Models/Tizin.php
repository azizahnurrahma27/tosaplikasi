<?php

namespace App\Models;

use App\Enums\IzinStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Tizin extends Model
{
    protected $connection = 'mai1';
    protected $table = 'tizin';
    protected $primaryKey = 'id';

    protected $appends = ['title'];
    protected $hidden = ['jen', 'jenis', 'updated_at', 'deleted_at'];

    protected $fillable = [
        'idsis', 'jen', 'tgl_mulai', 'tgl_akhir', 'ket', 'dok', 'sta',
        'approved_by', 'approved_at', 'alasan_tolak',
    ];

    protected $casts = [
        // 'sta' TIDAK dicast native di sini lagi
        'tgl_mulai' => 'date',
        'tgl_akhir' => 'date',
        'approved_at' => 'datetime',
    ];

    public function jenis(): BelongsTo
    {
        return $this->belongsTo(TizinJenis::class, 'jen', 'id');
    }

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Tsiswa::class, 'idsis', 'id');
    }

    public function documents(): MorphMany
    {
        $instance = (new Timagable())->setConnection('mai4');

        return $this->newMorphMany(
            $instance->newQuery(),
            $this,
            $instance->qualifyColumn('imagable_type'),
            $instance->qualifyColumn('imagable_id'),
            $this->getKeyName()
        );
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(Karyawan::class, 'approved_by', 'id');
    }

    /**
     * Accessor/mutator manual untuk 'sta' — pakai fromString() yang toleran
     * terhadap tipe kolom DB apa pun (string/int).
     */
    protected function sta(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value !== null ? IzinStatus::fromString((string) $value) : null,
            set: fn ($value) => $value instanceof IzinStatus ? $value->value : $value,
        );
    }

    protected function title(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->jenis?->nam ?? 'Izin #' . $this->id,
        );
    }
}