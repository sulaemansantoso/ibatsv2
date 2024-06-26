<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MK extends Model
{
    use HasFactory;

    protected $table = 'mk';

    protected $fillable = [
        'id_mk',
        'id_periode',
        'nama_mk',
        'jumlah_sks',
    ];

    public $timestamps = true;

}
