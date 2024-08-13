<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserKelas extends Model
{
    use HasFactory;


    protected $table = 'user_kelas';
    protected $primaryKey = 'id_user_kelas';
    protected $fillable = [
        'id_user',
        'id_kelas',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas');
    }


}
