<?php

namespace App\Imports;

use App\Models\UserKelas;
use App\Models\User;
use App\Models\MK;
use App\Models\Kelas;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UserKelasImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $id_user = User::where('kode_user', $row['nrp'])->first()->id;
        $id_mk = MK::where('kode_mk', $row['kode_mk'])->first()->id_mk;
        $id_kelas = Kelas::where('id_mk', $id_mk)->where('nama_kelas', $row['kelas'])->first()->id_kelas;

        return new UserKelas([
            //
            'id_user' => $id_user,
            'id_kelas' => $id_kelas,
        ]);
    }
}
