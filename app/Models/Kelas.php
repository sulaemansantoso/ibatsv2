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
}
