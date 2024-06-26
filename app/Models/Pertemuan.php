<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pertemuan extends Model
{
    use HasFactory;

    protected $table = 'pertemuan';

    protected $fillable = [
        'id_pertemuan',
        'id_mk',
        'id_periode',
        'pertemuan_ke',
        'jam_mulai',
        'jam_selesai',
    ];
}
