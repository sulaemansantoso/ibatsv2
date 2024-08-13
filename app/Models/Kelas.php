<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $table = 'kelas';
    protected $primaryKey = 'id_kelas';

    protected $fillable = [
        'id_kelas',
        'id_mk',
        'id_periode',
        'nama_kelas',
        'jam_mulai',
        'jam_selesai'
        ];

    public function periode()
    {
        return $this->belongsTo(Periode::class, 'id_periode');
    }

    public function mk()
    {
        return $this->belongsTo(MK::class, 'id_mk');
    }
 }
