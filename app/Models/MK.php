<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class MK extends Model
{
    use HasFactory;

    protected $table = 'mk';
    protected $primaryKey = 'id_mk';

    protected $fillable = [
        'id_mk',
        'id_periode',
        'nama_mk',
        'jumlah_sks',
    ];

    public $timestamps = true;


public function kelas() {
  return this.hasMany(Kelas::class,'id_mk');
}


}
