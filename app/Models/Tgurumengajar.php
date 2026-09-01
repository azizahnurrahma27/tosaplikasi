<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tgurumengajar extends Model
{
    protected $table = 'tgurumengajar';

    protected $fillable = ['idguru', 'idpelajaran', 'idkelas', 'idta'];

  public function guru(): BelongsTo
{
    return $this->belongsTo(Karyawan::class, 'idguru', 'id');
}

    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Tkelas::class, 'idkelas');
    }

    public function pelajaran(): BelongsTo
    {
        return $this->belongsTo(Tpelajaran::class, 'idpelajaran');
    }

    public function tahunAjaran(): BelongsTo
{
    return $this->belongsTo(Ttahunajaran::class, 'idta', 'id');
}
}