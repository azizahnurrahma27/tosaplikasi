<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ttingkat1 extends Model
{
    protected $connection = 'mai2';

    protected $table = 'ttingkat1';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'tin',
        'lev',
        'nam',
        'sta',
        'createdat',
        'updatedat',
    ];

    const CREATED_AT = 'createdat';
    const UPDATED_AT = 'updatedat';

    public function tingkat(): BelongsTo
    {
        return $this->belongsTo(Ttingkat::class, 'tin', 'id');
    }
}