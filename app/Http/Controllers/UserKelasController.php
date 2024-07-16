<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserKelas;

class UserKelasController extends Controller
{
    public function get() {
        return UserKelas::all();
    }

    public function insert(Request $request) {
        $userKelas = new UserKelas();
        $userKelas->id_user = $request->id_user;
        $userKelas->id_kelas = $request->id_kelas;
        $userKelas->save();
        return $userKelas;
    }

    public function update(Request $request) {
        $userKelas = UserKelas::find($request->id_user_kelas);
        $userKelas->id_user = $request->id_user;
        $userKelas->id_kelas = $request->id_kelas;
        $userKelas->save();
        return $userKelas;
    }

    public function delete(Request $request) {
        $userKelas = UserKelas::find($request->id_user_kelas);
        $userKelas->delete();
        return response()->json($userKelas);
    }


}
