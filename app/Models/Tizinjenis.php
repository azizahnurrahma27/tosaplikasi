<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tizinjenis extends Model
{
    protected $connection = 'mai1';
    protected $table = 'tizinjenis';
    protected $primaryKey = 'id';
    protected $appends = [];
    protected $hidden = [
        "created_at",
        "updated_at",
        "deleted_at",
        "sta",
    ];
    protected $fillable = [
        'title',
        'sta',
        'code',
    ];
}
