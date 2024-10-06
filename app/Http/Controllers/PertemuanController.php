<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pertemuan;

class PertemuanController extends Controller
{
    //

  public function get_pertemuan_by_id_kelas(Request $request) {
    $id_kelas = $request->id_kelas;

    $result= Pertemuan::select('id_kelas','id_pertemuan','tgl_pertemuan','jam_mulai', 'tgl_pertemuan')->where('id_kelas', $id_kelas)->get();
    
    foreach ($result as $p) {

    $p->tgl_pertemuan = date('d M Y', strtotime($p->tgl_pertemuan));
    $p->jam_mulai = date('H:i', strtotime($p->jam_mulai));    
    $p->tgl_jam = $p->tgl_pertemuan.' - '.$p->jam_mulai;

    }

    return response()->json([
      "data"=> $result
    ]);
  }

  public function get_pertemuan_by_id($id)
  {
    $pertemuan = Pertemuan::find($id);
    $pertemuan->tgl_pertemuan = date('d-M-Y', strtotime($pertemuan->tgl_pertemuan));
    $pertemuan->jam_mulai = date('H:i', strtotime($pertemuan->jam_mulai));

    $pertemuan->tgl_jam = $pertemuan->tgl_pertemuan . "-" . $pertemuan->jam_mulai;
    $pertemuan->kelas = $pertemuan->kelas;
    return response()->json($pertemuan);
  }

  public function get_pertemuan()
  {
    $pertemuan = Pertemuan::All();
  
    foreach ($pertemuan as $p) {
        $p->kelas = $p->kelas;
	$p->tgl_pertemuan = date('d M Y', strtotime($p->tgl_pertemuan));
	$p->jam_mulai = date('H:i', strtotime($p->jam_mulai));
    	$p->tgl_jam = $p->tgl_pertemuan . "-" . $p->jam_mulai;
    }


    return response()->json($pertemuan);
  }

  public function insert(Request $request)
  {
    try {
      $pertemuan = new Pertemuan();
      $pertemuan->id_kelas = $request->id_kelas;
      $pertemuan->tgl_pertemuan = $request->tgl_pertemuan;
      $pertemuan->jam_mulai = $request->jam_mulai;
      $pertemuan->jam_selesai = $request->jam_mulai;
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
    $pertemuan->jam_mulai = $request->jam_mulai?$request->jam_mulai:$pertemuan->jam_mulai;
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
