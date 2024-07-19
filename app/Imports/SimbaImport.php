<?php

namespace App\Imports;

use App\Models\UserKelas;
use App\Models\MK;
use App\Models\User;
use App\Models\Kelas;


use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;



class SimbaImport implements ToModel, WithHeadingRow, WithStartRow
{
    public function startRow(): int
    {
        return 2;
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {



        //get course info
        $course = $row["course"];
        $cSplit = explode(" - ", $course);
        $kode_mk = $cSplit[0];
        $nama_mk = $cSplit[1];


        //get lecturer info
        $lecturer = $row["lecturer"];
        $lSplit = explode(" - ", $lecturer);
        $kode_user = $lSplit[0];
        $name = $lSplit[1];

        //get other info
        $class_no = $row["class"];
        if ($row["type"] == "Teori") {

            $class_type = 0;
        }
        else {

            $class_type = 1;
        }

        //if course doesn't exist, create
        $mkfinder = MK::where('kode_mk', $kode_mk)->first();
        if ($mkfinder == null) {
            $mk = new MK();
            $mk->kode_mk = $kode_mk;
            $mk->nama_mk = $nama_mk;
            $mk->sks_mk = 2;
            $mk->save();


            $id = $mk->getKey();
            //is there a less exhaustive way ?
            $mkfinder = MK::where('id_mk', $id)->first();
        }

        //if user doesn't exist, create
        $userfinder = User::where('kode_user', $kode_user)->first();
        if ($userfinder == null) {
            $user = new User();
            $user->kode_user = $kode_user;
            $user->name = $name;
            $user->email = $kode_user;
            $user->password = bcrypt($kode_user);
            $user->role = 2;//dosen
            $user->save();
            $id = $user->getKey();

            $userfinder = User::where('id', $id)->first();
        }

        //if periode doesn't exist, create


        //if class doesn't exist, create
        $classfinder = Kelas::where('id_mk', $mkfinder->id_mk)->where('tipe_kelas', $class_type)->where('id_periode', 1)->where('nama_kelas', $class_no)->first();
        if ($classfinder == null) {
            echo "create class $class_no and mk $mkfinder->id_mk \n";

            $class = new Kelas();
            $class->id_mk = $mkfinder->id_mk;
            $class->id_periode = 1;
            $class->jam_mulai = "07:00:00";
            $class->jam_selesai = "09:00:00";
            // $class->id_user = $userfinder->id;
            $class->nama_kelas = $class_no;
            $class->tipe_kelas = $class_type;
            $class->save();

            $classfinder = Kelas::where('id_mk', $mkfinder->id_mk)->where('tipe_kelas', $class_type)->where('id_periode',1)->where('nama_kelas', $class_no)->first();
        }

        $userkelasFinder = UserKelas::where('id_user', $userfinder->id)->where('id_kelas', $classfinder->id_kelas)->first();
        if ($userkelasFinder == null){
            return new UserKelas([
                'id_user' => $userfinder->id,
                'id_kelas' => $classfinder->id_kelas
            ]);
        }
        else {
            return null;
        }

    }
}
