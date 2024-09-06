<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pertemuan;
use App\Models\PertemuanPhoto;
use App\Models\Photo;
use File;
use Storage;
class PertemuanPhotoController extends Controller
{
    //


    public function AddPhoto(Request $request){
        // $id_pertemuan = $request->id_pertemuan;
        $id_pertemuan = $request->input('id_pertemuan');

        $id_kelas = Pertemuan::find($id_pertemuan)->kelas->id_kelas;
        $file_input = $request->file('file');
        //store the image
        $destination_path = $id_kelas . '/' . $id_pertemuan ;

        $file_input = $request->file('file');
        $image = $file_input->store('photo/'.$id_kelas . '/' . $id_pertemuan, 'public');
        $image_filename = basename($image);


        //store the path in the database
        // $photo = new Photo();
        // $photo->path = $path;
        // $photo->save();
        // $id_photo = $photo->id_photo;

        // $pertemuan_photo = new PertemuanPhoto();
        // $pertemuan_photo->id_pertemuan = $id_pertemuan;
        // $pertemuan_photo->id_photo = $id_photo;
        // $pertemuan_photo->save();

        //$executePython = "python /var/www/html/ibatsv2/splitImage.py '" .$destination_path ."'" . $filename . " " . ; ;
        //  $executionScript = "python ../testos.py";
        $executionScript = "python ../splitImage.py ".$destination_path ." " . $image_filename . " " . $id_pertemuan;
        //echo $executionScript;
        $result = exec($executionScript);


        //once the image is stored in public folder
        //the image should then be spliced by the face detection algorithm
        //and then stored_back in the database with
        //entry on kehadiran table with no student --"a

        // $pertemuan->save();
        return $result;
    }

}
