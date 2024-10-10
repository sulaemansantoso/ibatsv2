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
    *
    * @return \Illuminate\Database\Eloquent\Model|UserKelas
    *
    */
    public function model(array $row)
    {
        $user = User::where('kode_user', $row['nrp'])->first();

        if (!is_null($user)){
            $id_user = $user->id;
        }
        else {
            $user = new User([
                'kode_user' => $row['nrp'],
                'name' => $row['nama'],
                'password' => bcrypt($row['nrp']),
                'role' => 3,
                'email' => $row['nrp']. '@maranatha.ac.id',
            ]);
            $user->save();
            $id_user = $user->id;
        }
        $id_mk = MK::where('kode_mk', $row['kode_mk'])->first()->id_mk;
        if (is_null($id_mk)) {
            return;
        }

        $id_kelas = Kelas::where('id_mk', $id_mk)->where('nama_kelas', $row['kelas'])->first()->id_kelas;
        if (is_null($id_kelas)) {
            return;
        }

        $user_kelas_finder = UserKelas::where('id_user', $id_user)->where('id_kelas', $id_kelas)->first();
        if ($user_kelas_finder) {
            return;
        }

        return new UserKelas([
            //
            'id_user' => $id_user,
            'id_kelas' => $id_kelas,
        ]);
    }
}
