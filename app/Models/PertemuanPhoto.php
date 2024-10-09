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
        'id_user',
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function photo()
    {
        return $this->belongsTo(Photo::class, 'id_photo');
    }

    public function pertemuan()
    {
        return $this->belongsTo(Pertemuan::class, 'id_pertemuan');
    }
}
