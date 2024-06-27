<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PertemuanPhoto extends Model
{
    use HasFactory;

    protected $table = 'pertemuan_photo';
    protected $primaryKey = 'id_pertemuan_photo';

    protected $fillable = [
        'id_pertemuan_photo',
        'id_pertemuan',
        'id_photo',
    ];

    public function pertemuan()
    {
        return $this->belongsTo(Pertemuan::class, 'id_pertemuan');
    }
}
