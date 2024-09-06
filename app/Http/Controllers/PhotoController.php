<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Photo;
use Illuminate\Support\Facades\Storage;
use File;

class PhotoController extends Controller
{

    public function get_photo_by_id($id)
    {
        $photo = Photo::find($id);
        return response()->json([
	  "data"=> $photo
	]);
    }

    public function get_photo()
    {
        $photo = Photo::all();
        return response()->json(
	[
	 "data" => $photo
	]);
    }

    public function insert(Request $request)
    {
        try {
            $image = $request->file('file')->store('photo', 'public');
            $path = $image;

            //$image->move(public_path('photo'), $image->getClientOriginalName());
            //$path = "photo/" . $image->getClientOriginalName();

            $photo = new Photo();
            $photo->path = $path;
            $photo->save();
        }
        catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
        return response()->json($photo);
    }

    public function update(Request $request)
    {
        //delete image in public folder
        $photo = Photo::find($request->id_photo);

        $photo->path = $request->path?$request->path:$photo->path;
        $photo->save();
        return response()->json($photo);
    }

    public function delete(Request $request)
    {
        $photo = Photo::find($request->id_photo);

        $path = $photo->path;

        // if (Storage::exists("public/".$path)) {
        //     echo "File exists";
        // }
        Storage::delete("public/".$path);
        $photo->delete();
        return response()->json($photo);
    }

}
