<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Http\JsonResponse;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UserImports;

class MyAuthController extends BaseController
{
    public function import_user_by_excel(Request $request)
    {
        //this code imports users from csv sent from $request
        try {
            Excel::import(new UserImports, $request->file('file'));
        }
        catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
        return $this->sendResponse('User import Succesfully', 'User import Succesfully');
    }


    public function getjson() {
        return $this->sendResponse('TestAPI succesfull', 'Test API returns Succesfully');
    }

    public function ClearAllToken() {
        //delete all active token on laravel

    }


    public function login2(Request $request) {
        $data = $request->json()->all();
        if (Auth::attempt(['kode_user' => $data['kode_user'], 'password' => $data['password']])) {
            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')->plainTextToken;
            $success['token'] = explode('|', $success['token'])[1];
            $success['name'] =  $user->name;
            $success['id_user'] = $user->kode_user;
            $success['email'] = $user->email;
            return $this->sendResponse($success, 'User Login Succesfully');
        } else {
            return $this->sendError('Unauthorised', ['error'=>'Unauthorised']);
        }
    }


    public function register2(Request $request) {
     $data = $request->json()->all();
     $validator = Validator::make($data, [
         'name' => 'required',
         'email' => 'required|email',
         'password' => 'required',
         'kode_user' => 'required',
     ]);
     if($validator->fails()){
         return $this->sendError('validation error', $validator->errors());
     }
     $input = $request->all();
     $input['password'] = bcrypt($input['password']);
     $user = User::create($input);
     $success['token'] =  $user->createToken('MyApp')->plainTextToken;
     $success['token'] = explode('|', $success['token'])[1];
     $success['name'] =  $user->name;
     return $this->sendResponse($success, 'User Register Succesfully');
    }

   public function register(Request $request) {
    $validator = Validator::make($request->all(), [
        'name' => 'required',
        'email' => 'required|email',
        'password' => 'required',
        'kode_user' => 'required',
    ]);

    if($validator->fails()){
        return $this->sendError('validation error', $validator->errors());
    }
    $input = $request->all();
    $input['password'] = bcrypt($input['password']);
    $user = User::create($input);
    $success['token'] =  $user->createToken('MyApp')->plainTextToken;
    $success['token'] = explode('|', $success['token'])[1];
    $success['name'] =  $user->name;
    $success['id_user'] = $user->kode_user;
    $success['email'] = $user->email;
    return $this->sendResponse($success, 'User Register Succesfully');

   }

   public function login (Request $request) : JsonResponse {
    if (Auth::attempt(['kode_user' => $request->kode_user, 'password' => $request->password])){
        $user = Auth::user();
        $success['token'] =  $user->createToken('MyApp')->plainTextToken;
        $success['token'] = explode('|', $success['token'])[1];
        $success['name'] =  $user->name;
        return $this->sendResponse($success, 'User Login Succesfully');
    }
    else {
        return $this->sendError('Unauthorised', ['error'=>'Unauthorised']);
    }
   }

   public function logout (Request $request) : JsonResponse {

     $token = $request->user()->currentAccessToken()->delete();
     return $this->sendResponse($token, 'User Logout Succesfully');
   }
}
