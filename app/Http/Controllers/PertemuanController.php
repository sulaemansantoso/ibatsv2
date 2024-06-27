<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pertemuan;

class PertemuanController extends Controller
{
    //

  public function get_pertemuan()
  {
    $pertemuan = Pertemuan::all();
    foreach ($pertemuan as $p) {
        $p->kelas = $p->kelas;
    }

    return response()->json($pertemuan);
  }

  public function insert(Request $request)
  {
    try {
      $pertemuan = new Pertemuan();
      $pertemuan->id_materi = $request->id_materi;
      $pertemuan->id_periode = $request->id_periode;
      $pertemuan->pertemuan = $request->pertemuan;
      $pertemuan->save();
    }
    catch (\Exception $e) {
      return response()->json($e->getMessage());
    }
    return response()->json($pertemuan);
  }

  public function update(Request $request)
  {
    $pertemuan = Pertemuan::find($request->id_pertemuan);
    $pertemuan->id_materi = $request->id_materi?$request->id_materi:$pertemuan->id_materi;
    $pertemuan->id_periode = $request->id_periode?$request->id_periode:$pertemuan->id_periode;
    $pertemuan->pertemuan = $request->pertemuan?$request->pertemuan:$pertemuan->pertemuan;
    $pertemuan->save();
    return response()->json($pertemuan);
  }

  public function delete(Request $request)
  {
    $pertemuan = Pertemuan::find($request->id_pertemuan);
    $pertemuan->delete();
    return response()->json($pertemuan);
  }

}
