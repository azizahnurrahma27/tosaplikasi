<?php

namespace App\Models;

use App\Models\Tsiswafoto;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tsiswa extends Model
{
    protected $connection = 'mai2';
    protected $table = 'tsiswa';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $keyType = 'int';
    protected $fillable = [
        'id',
        'nis',
        'nisn',
        'namlen',
        'nampan',
        'namnam',
        'temlah',
        'tgllah',
        'jenkel',
        'tel',
        'rev',
        'kel',
    ]; 

    public function detail()
    {
        return $this->hasOne(Tsiswa1::class, 'ids','id');
    }

    public function detailsiswa()
    {
        return $this->hasOne(Tsiswafoto::class,'ids','id');
    }

    public function kelas()
    {
        return $this->belongsTo(Tkelas::class, 'kel', 'nam');
    }

    public function fotosiswa()
    {
        return $this->hasOne(Tsiswafoto::class,'ids','id');
    }

    public function kelsis()
    {
        return $this->hasMany(Tkelsis::class,'ids','id');   
    }

    public function rapor(): HasMany
    {
        return $this->hasMany(Rapor::class, 'idsiswa');
    }

    public function faceRegistration()
    {
        return $this->hasOne(StudentFaceRegistration::class, 'student_id');
    }
}