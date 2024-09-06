<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\MK;

class MKController extends Controller
{
    //

    public function get_mk()
    {
        $mk = MK::all();
        return response()->json(
	[
	"data"=>$mk
	]);
    }

    public function insert(Request $request)
    {
        try {
            $mk = new MK();
            $mk->kode_mk = $request->kode_mk;
            $mk->nama_mk = $request->nama_mk;
            $mk->sks_mk = $request->sks_mk;
            $mk->save();
        }
        catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
        return response()->json($mk);

    }

    public function update(Request $request)
    {
        $mk = MK::find($request->id_mk);
        $mk->kode_mk = $request->kode_mk?$request->kode_mk:$mk->kode_mk;
        $mk->nama_mk = $request->nama_mk?$request->nama_mk:$mk->nama_mk;
        $mk->sks_mk = $request->sks_mk?$request->sks_mk:$mk->sks_mk;
        $mk->save();
        return response()->json($mk);
    }

    public function delete(Request $request)
    {
        $mk = MK::find($request->id_mk);
        $mk->delete();
        return response()->json($mk);
    }


}
