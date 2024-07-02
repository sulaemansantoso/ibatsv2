<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pertemuan extends Model
{
    use HasFactory;

    protected $table = 'pertemuan';
    protected $primaryKey = 'id_pertemuan';

    protected $fillable = [
        'id_pertemuan',
        'id_kelas',
        'no_pertemuan',
        'tgl_pertemuan',
        'jam_mulai',
        'jam_selesai',
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas');
    }

    public function photos () {
        return $this->hasMany(PertemuanPhoto::class, 'id_pertemuan');
    }

    public function kehadirans () {
        return $this->hasMany(Kehadiran::class, 'id_pertemuan');
    }

}
