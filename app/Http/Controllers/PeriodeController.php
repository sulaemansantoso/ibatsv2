<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Periode;

class PeriodeController extends Controller
{
    //

    public function get_periode()
    {
        $periode = Periode::all();

        foreach ($periode as $p) {
            $p->tgl_mulai = date('d-M-Y', strtotime($p->tgl_mulai));
            $p->tgl_selesai = date('d-M-Y', strtotime($p->tgl_selesai));
        }
        return response()->json($periode);
    }

    public function insert(Request $request)
    {
        try {
            $periode = new Periode();
            $periode->nama_periode = $request->nama_periode;
            $periode->tgl_mulai = $request->tgl_mulai;
            $periode->tgl_selesai = $request->tgl_selesai;
            $periode->save();
        }
        catch (\Exception $e) {
            return response()->json($e->getMessage());
        }

        return response()->json($periode);
    }

    public function update(Request $request)
    {
        $periode = Periode::find($request->id_periode);
        $periode->nama_periode = $request->nama_periode?$request->nama_periode:$periode->nama_periode;
        $periode->tgl_mulai = $request->tgl_mulai?$request->tgl_mulai:$periode->tgl_mulai;
        $periode->tgl_selesai = $request->tgl_selesai?$request->tgl_selesai:$periode->tgl_selesai;

        $periode->save();
        return response()->json($periode);
    }

    public function delete(Request $request)
    {
        $periode = Periode::find($request->id_periode);
        $periode->delete();
        return response()->json($periode);
    }
}
