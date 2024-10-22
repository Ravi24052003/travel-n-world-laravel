<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\SignupRequest;
use App\Http\Resources\SignupResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function signup(SignupRequest $request){
    $data = $request->validated();

    User::create($data);

     return response()->json(["message"=>"Your account created successfully soon our team will verify your account"], 201);

    }

    public function login(LoginRequest $request){
        $credentials = $request->validated();

        if(!Auth::attempt($credentials)){
            return response()->json([
                'message'=>"Password is incorrect"
            ], 401);
        }

         /** @var User $user */
        $user = Auth::user();

       $token = $user->createToken("API TOKEN")->plainTextToken;

       $res = new SignupResource($user);

        return response()->json([
            'user'=>$res,
             'token'=>$token
        ], 200);

    }

    public function logout(Request $request){
     $user = $request->user(); //gives currently authenticated user
     $user->tokens()->delete();

    // $user->currentAccessToken()->delete();

     return response()->json([
        "status"=>true,
        "message"=>"User logged out successfully",
     ], 204);
    }
}
