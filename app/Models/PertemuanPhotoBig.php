<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PertemuanPhotoBig extends Model
{
    use HasFactory;

    protected $table = 'pertemuan_photo_big';

    protected $fillable = [
        'pertemuan_id',
        'id_photo',
    ];

    public function photo()
    {
        return $this->belongsTo(Photo::class, 'id_photo');
    }

    public function pertemuan()
    {
        return $this->belongsTo(Pertemuan::class, 'pertemuan_id');
    }

}
