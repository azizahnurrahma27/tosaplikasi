<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class EventCategory extends Model
{

    protected $connection = 'mai1';
    protected $table = 'event_categories';

    protected $fillable = [
        'slug',
        'name',
        'color',
        'icon',
    ];

    public function events()
    {
        return $this->hasMany(Event::class, 'kategori_id');
    }
}
