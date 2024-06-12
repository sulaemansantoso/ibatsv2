<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Http\JsonResponse;

class MyAuthController extends BaseController
{
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
    $success['name'] =  $user->name;
    return $this->sendResponse($success, 'User Register Succesfully');

   }

   public function login (Request $request) : JsonResponse {
    if (Auth::attempt(['kode_user' => $request->kode_user, 'password' => $request->password])){
        $user = Auth::user();
        $success['token'] =  $user->createToken('MyApp')->plainTextToken;
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
