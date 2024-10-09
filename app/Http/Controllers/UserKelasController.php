<?php

namespace App\Http\Controllers;

use App\Imports\SimbaImport;
use Illuminate\Http\Request;
use App\Models\UserKelas;
use App\Models\User;
use App\Models\MK;
use App\Imports\UserKelasImport;
use Maatwebsite\Excel\Facades\Excel;

class UserKelasController extends BaseController
{

    public function import_mahasiswa_from_excel(Request $request) {
        Excel::import(new UserKelasImport, $request->file('file'));
        return $this->sendResponse('Mahasiswa Kelas import Succesfully', 'UserKelas import Succesfully');
    }


    public function import_from_simba(Request $request) {
        Excel::import(new SimbaImport, $request->file('file'));
        return $this->sendResponse('Simba import Succesfully', 'Simba import Succesfully');
    }

    public function import_from_excel(Request $request) {
        Excel::import(new UserKelasImport, $request->file('file'));
        return $this->sendResponse('Kelas import Succesfully', 'UserKelas import Succesfully');
    }

    public function get() {
        return UserKelas::all();
    }


    public function get_kelas_by_id(Request $request) {
        $kode_user = $request->kode_user;
	$user = User::where('kode_user', $kode_user)->first();


        $result =  UserKelas::where('id_user', $user->id)->get(['id_user_kelas','id_user', 'id_kelas']);

        foreach ($result as $r) {
            $r->kelas = $r->kelas;
            $r->kelas->mk = $r->kelas->mk->get(['kode_mk','nama_mk']);
            // $r->user = $r->user;
        }
        // return $result;
        return response()->json([
            "data" => $result ]);
    }

    public function get_kelas_by_id_custom (Request $request) {
        $kode_user = $request->kode_user;

        $user = User::where('kode_user', $kode_user)->first();

        //$result =  UserKelas::where('id_user', $user->id)->get(['id_user_kelas','id_user', 'id_kelas']);
        $result = UserKelas::with('kelas','user')->where('id_user', $user->id)->get();


        $adjusted_result = [];
        foreach ($result as $r) {
            $temp = new UserKelas;
            $temp->id_user = $r->user->kode_user;
            $temp->id_kelas = $r->kelas->id_kelas;
            $temp->kode_mk = $r->kelas->mk->kode_mk;
            $temp->nama_mk = $r->kelas->mk->nama_mk;
            $temp->nama_kelas = $r->kelas->nama_kelas;
            $temp->jam_mulai = $r->kelas->jam_mulai;
            $temp->jam_selesai = $r->kelas->jam_selesai;
            $adjusted_result[] = $temp;
            // $r->user = $r->user;
        }
        // return $result;
        return response()->json([
            "data" => $adjusted_result ]);
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
