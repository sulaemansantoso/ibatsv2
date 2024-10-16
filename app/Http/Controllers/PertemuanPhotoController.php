<?php

namespace App\Http\Controllers;
//require './vendor/autoload.php';

use Illuminate\Http\Request;
use App\Models\Pertemuan;
use App\Models\PertemuanPhoto;
use App\Models\Photo;
use App\Models\User;
use File;
use Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class PertemuanPhotoController extends Controller
{

    public function untag_pertemuan_photo(Request $request) {
        $id_pertemuan_photo = $request->id_pertemuan_photo;
        $finder = PertemuanPhoto::find($id_pertemuan_photo);
        $finder->id_user = null;
        $result = $finder->save();
        return response()->json($result);
    }
    //
    public function tag_pertemuan_photo(Request $request) {
        $kode_user = $request->id_user;
        $id_pertemuan_photo = $request->id_pertemuan_photo;

        $finder = PertemuanPhoto::find($id_pertemuan_photo);

        //cek if user exist then get user_id
	    if (is_null($finder->id_user)) {
	        $user = User::where("kode_user", $kode_user)->first();

        //if user didnt exist
        if(is_null($user)) {
		    return response()->json(["message" => "user id not found or invalid"]);
	    }
	    $id_user = $user->id;
	    $finder->id_user = $id_user;
       	$result = $finder->save();

        return response()->json([
            "data"=> $finder
        ]);
	}
	return response()->json([
		"message"=> "photo already tagged"
	]);
    }

    public function get_pertemuan_photo_by_id(Request $request) {
        $id = $request->id_pertemuan;


        $finder = PertemuanPhoto::with('photo','user')->where('id_pertemuan', $id)->get();
        if (is_null($finder)) {
	  return response()->json(["message"=>"id_pertemuan not found or invalid"]);
	}

	$result = [];

        foreach($finder as $f) {
	    $temp = new PertemuanPhoto;
            $temp->id_pertemuan_photo = $f->id_pertemuan_photo;
	    if (! is_null($f->user)) {
            	$temp->idStudent = $f->user->kode_user;
            	$temp->name = $f->user->name;
	    }
 	    $temp->path = $f->photo->path;
            $result[] = $temp;
       }

        return response()->json([
        "data"=> $result ]);

    }

    public function get_pertemuan_photo(Request $request) {
	    $result = PertemuanPhoto::all();
	    return response()->json([
	    "data"=> $result ]);
    }

    public function get_pertemuan_photo_by_id_pertemuan(Request $request) {
        $id_pertemuan = $request->id_pertemuan;
        $result = PertemuanPhoto::where('id_pertemuan', $id_pertemuan)->get();


        return response()->json([
        "data"=> $result ]);
    }


  public function TestPhoto(Request $request) {

	$file = $request->file('file');
	$image= $file->store('test_photo2','public');
	echo $image;
  }

   public function AddPhoto2(Request $request) {

  	$file = $request->file('file');

	$image = $file->store('test_photo', 'public');
  	echo  $image;

  	 return $file->path() . ' id_pertemuan : ' . $request->input('id_pertemuan');
   }


    public function AddPhoto(Request $request){
        // $id_pertemuan = $request->id_pertemuan;
        $id_pertemuan = $request->input('id_pertemuan');
	$file_input = $request->file('file');

	$validator = \Validator::make(['file' => $file_input], [
        	'file' => 'required|image|mimes:jpeg,png,jpg,gif',
    	]);

    	if ($validator->fails()) {
        	return response()->json([
            	'data' => [],
            	'message' => "File harus berformat jpeg, jpg, png, atau gif.",
        	], 200);
    	}
    	$fileSize = $file_input->getSize() / 1024; // Ukuran dalam KB
        $maxSize = 2048;
        $manager = new ImageManager(new Driver());
	if ($fileSize > $maxSize) {
            // Resize gambar jika ukuran file lebih besar dari yang diizinkan
            $tempPath = 'temp/' . $file_input->getClientOriginalName();
	    $file_input->move(public_path('temp'), $file_input->getClientOriginalName());

	    // Gunakan read untuk memuat gambar dari path
	    $img = $manager->read(public_path($tempPath));
	    $percentage = 50;

	    // Hitung ukuran baru berdasarkan persentase
	    $newWidth = $img->width() * ($percentage / 100);
	    $newHeight = $img->height() * ($percentage / 100);

	    // Resize gambar
	    $img->resize($newWidth, $newHeight);

            // Simpan gambar sementara untuk mendapatkan path
            $tempPath = 'temp/' . $file_input->getClientOriginalName();
            $img->save(public_path($tempPath));

            // Ganti file_input dengan gambar yang sudah diresize
            $file_input = new \Illuminate\Http\UploadedFile(public_path($tempPath), $file_input->getClientOriginalName());
        }

        $id_kelas = Pertemuan::find($id_pertemuan)->kelas->id_kelas;
        //$file_input = $request->file('file');
        //store the image
        $destination_path = $id_kelas . '/' . $id_pertemuan ;

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
        $executionScript = "python3 ../splitImage.py ".$destination_path ." " . $image_filename . " " . $id_pertemuan;

        $result = exec($executionScript);
	$result = json_decode($result,true);
        //once the image is stored in public folder
        //the image should then be spliced by the face detection algorithm
        //and then stored_back in the database with
        //entry on kehadiran table with no student --"a
        // $pertemuan->save();
	//return $result;
        return response()->json($result);
    }


}
