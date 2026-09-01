<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentFaceRegistration extends Model
{
    protected $fillable = [
        'student_id',
        'employee_no',
        'photo_path',
        'registered_on_device',
        'only_verify',
        'last_error'
    ];

    public function siswa()
    {
        return $this->belongsTo(Tsiswa::class, 'student_id');
    }
}
