<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $connection = 'mai5';

    protected $fillable = [
        'device_id',
        'student_id',
        'employee_no',
        'name',
        'event_time',
        'attendance_status',
        'serial_no',
        'picture_path',
        'raw_payload',
    ];

    protected $casts = [
        'event_time' => 'datetime',
        'raw_payload' => 'array',
    ];


    public function tsiswa()
    {
        return $this->belongsTo(Tsiswa::class, 'student_id', 'id');
    }
}