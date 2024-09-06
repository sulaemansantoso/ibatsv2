<?php

namespace App\Http\Controllers;
use App\Models\Kehadiran;

use Illuminate\Http\Request;

class KehadiranController extends Controller
{
    //

    public function get_kehadiran_by_id($id)
    {
        $kehadiran = Kehadiran::find($id);
        $kehadiran->pertemuan = $kehadiran->pertemuan;
        return response()->json(
	[
	"data" => $kehadiran
	]);
    }

    public function get_kehadiran()
    {
        $kehadiran = Kehadiran::all();
        foreach ($kehadiran as $k) {
            $k->pertemuan = $k->pertemuan;
        }
    }

    public function insert(Request $request)
    {
        try {
            $kehadiran = new Kehadiran();
            $kehadiran->id_pertemuan = $request->id_pertemuan;
            $kehadiran->id_siswa = $request->id_siswa;
            $kehadiran->kehadiran = $request->kehadiran;
            $kehadiran->save();
        }
        catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
        return response()->json($kehadiran);
    }


    public function update(Request $request)
    {
        $kehadiran = Kehadiran::find($request->id_kehadiran);
        $kehadiran->id_pertemuan = $request->id_pertemuan?$request->id_pertemuan:$kehadiran->id_pertemuan;
        $kehadiran->id_siswa = $request->id_siswa?$request->id_siswa:$kehadiran->id_siswa;
        $kehadiran->kehadiran = $request->kehadiran?$request->kehadiran:$kehadiran->kehadiran;
        $kehadiran->save();
        return response()->json($kehadiran);
    }


    public function delete(Request $request)
    {
        $kehadiran = Kehadiran::find($request->id_kehadiran);
        $kehadiran->delete();
        return response()->json($kehadiran);
    }





}
