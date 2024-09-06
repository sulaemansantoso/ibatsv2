<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Kelas;

class KelasController extends Controller
{
    //

    public function get_kelas()
    {
        $kelas = Kelas::all();

        foreach ($kelas as $k) {
            $k->mk = $k->mk;
            $k->periode = $k->periode;
        }
        return response()->json(
	[
	"data"=> $kelas
	]);
    }

    public function insert(Request $request)
    {
        try {
            $kelas = new Kelas();
            $kelas->id_mk = $request->id_mk;
            $kelas->id_periode = $request->id_periode;
            $kelas->nama_kelas = $request->nama_kelas;
            $kelas->jam_mulai = $request->jam_mulai;
            $kelas->jam_selesai = $request->jam_selesai;
            $kelas->save();
        }
        catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
        return response()->json($kelas);
    }

    public function update(Request $request)
    {
        $kelas = Kelas::find($request->id_kelas);
        $kelas->id_mk = $request->id_mk?$request->id_mk:$kelas->id_mk;
        $kelas->id_periode = $request->id_periode?$request->id_periode:$kelas->id_periode;
        $kelas->nama_kelas = $request->nama_kelas?$request->nama_kelas:$kelas->nama_kelas;
        $kelas->jam_mulai = $request->jam_mulai?$request->jam_mulai:$kelas->jam_mulai;
        $kelas->jam_selesai = $request->jam_selesai?$request->jam_selesai:$kelas->jam_selesai;
        $kelas->save();
        return response()->json($kelas);
    }

    public function delete(Request $request)
    {
        $kelas = Kelas::find($request->id_kelas);
        $kelas->delete();
        return response()->json($kelas);
    }
}
