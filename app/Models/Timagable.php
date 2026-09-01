<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Timagable extends Model
{
    protected $connection = 'mai4';
    protected $table = 'timagable';
    protected $primaryKey = 'id';
    protected $appends = ['url', 'image_size'];

    protected $fillable = [
        'name',
        'path',
        'mime_type',
        'size',
        'imagable_id',
        'imagable_type',
    ];

    /**
     * Relasi morph ke model induk (misalnya: Tregistrasi, Tsiswa, dll)
     */
    public function imagable()
    {
        return $this->morphTo();
    }

    /**
     * Akses URL file (mengandalkan storage publik)
     */
public function getUrlAttribute(): ?string
{
    if (!$this->path) return null;

    $base = config('app.mai4_storage_url', env('MAI4_STORAGE_URL'));

    return $base
        ? rtrim($base, '/') . '/storage/' . ltrim($this->path, '/')
        : asset('storage/' . $this->path);
}
    /**
     * Tampilkan ukuran file dalam format ramah (KB/MB)
     */
    public function getImageSizeAttribute(): string
    {
        $size = $this->size ?? 0;
        if ($size >= 1048576) {
            return number_format($size / 1048576, 2) . ' MB';
        } elseif ($size >= 1024) {
            return number_format($size / 1024, 2) . ' KB';
        }
        return $size . ' B';
    }
}
