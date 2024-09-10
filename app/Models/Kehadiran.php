<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pertemuan;
use App\Models\User;

class Kehadiran extends Model
{
    use HasFactory;

    protected $table = 'kehadiran';
    protected $primaryKey = 'id_kehadiran';

    protected $fillable = [
        'id_kehadiran',
        'id_pertemuan',
        'id_siswa',
        'id_pertemuan_photo',
    ];

    public function pertemuan()
    {
        return $this->belongsTo(Pertemuan::class, 'id_pertemuan');
    }

    public function siswa()
    {
        return $this->belongsTo(User::class, 'id_siswa');
    }

    public function pertemuan_photo()
    {
        return $this->belongsTo(PertemuanPhoto::class, 'id_pertemuan_photo');
    }
}
