<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pertemuan;

class PertemuanController extends Controller
{
    //

  public function get_pertemuan_by_id($id)
  {
    $pertemuan = Pertemuan::find($id);
    $pertemuan->kelas = $pertemuan->kelas;
    return response()->json($pertemuan);
  }

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
      $pertemuan->id_kelas = $request->id_kelas;
      $pertemuan->no_pertemuan = $request->no_pertemuan;
      $pertemuan->tgl_pertemuan = $request->tgl_pertemuan;
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
    $pertemuan->id_kelas = $request->id_kelas?$request->id_kelas:$pertemuan->id_kelas;
    $pertemuan->no_pertemuan = $request->no_pertemuan?$request->no_pertemuan:$pertemuan->no_pertemuan;
    $pertemuan->tgl_pertemuan = $request->tgl_pertemuan?$request->tgl_pertemuan:$pertemuan->tgl_pertemuan;
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
