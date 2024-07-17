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
        $id_mk = $cSplit[0];
        $nama_mk = $cSplit[1];


        //get lecturer info
        $lecturer = $row["lecturer"];
        $lSplit = explode(" - ", $lecturer);
        $kode_user = $lSplit[0];
        $name = $lSplit[1];

        //get other info
        $class_no = $row["Class"];
        $class_type = $row["Type"];

        //if course doesn't exist, create
        $mkfinder = MK::where('id_mk', $id_mk)->first();
        if ($mkfinder == null) {
            $mk = new MK();
            $mk->id_mk = $id_mk;
            $mk->kode_mk = $id_mk;
            $mk->nama_mk = $nama_mk;
            $mk->save();

            //is there a less exhaustive way ?
            $mkfinder = MK::where('id_mk', $id_mk)->first();
        }

        //if user doesn't exist, create
        $userfinder = User::where('kode_user', $kode_user)->first();
        if ($userfinder == null) {
            $user = new User();
            $user->kode_user = $kode_user;
            $user->name = $name;
            $user->email = $kode_user;
            $user->password = bcrypt($kode_user);
            $user->role = 2;
            $user->save();

            $userfinder = User::where('kode_user', $kode_user)->first();
        }

        //if class doesn't exist, create
        $classfinder = Kelas::where('id_mk', $mkfinder->id_mk)->where('nama_kelas', $class_no)->first();
        if ($classfinder == null) {
            $class = new Kelas();
            $class->id_mk = $mkfinder->id_mk;
            $class->id_user = $userfinder->id_user;
            $class->nama_kelas = $class_no;
            $class->type = $class_type;
            $class->save();

            $classfinder = Kelas::where('id_mk', $mkfinder->id_mk)->where('nama_kelas', $class_no)->first();
        }

        return new UserKelas([
            //
        ]);
    }
}
