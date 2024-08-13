<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UserImports implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new User([
            // 'kode_user'=>$row[0],
            // 'name'=>$row[1],
            // 'email'=>$row[2],
            // 'password'=>bcrypt($row[3]),
            // 'role'=>$row[4],
            'name' => $row['name']?? $row['username'] ?? $row['Name'] ?? $row['nama'] ,
            'email' => $row['email'] ?? $row['Email'] ?? $row['email address'],
            'password' => bcrypt($row['password'] ?? $row['Password']),
            'kode_user' => $row['kode_user'] ?? $row['Kode User'] ?? $row['nrp'] ?? $row['NRP'] ?? $row['NIK'] ?? $row['nik'],
            'role' => $row['role'] ?? $row['Role'],
        ]);
    }
}
