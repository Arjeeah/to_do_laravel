<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function store(Request $request)
    {
        $input=$request->validate([
            "name"=> ["required",'string'],
            'email'=> ['string','email','required','unique:users,email'],
            'password'=> ['required','string'],
            'avatar_url'=>['string','nullable'],
            'DOB'=>['date','required'],
        ]);
        User::create([
            'name'=> $input['name'],
            'email'=> $input['email'],
            'password'=> Hash::make($input['password']),
            'DOB'=> $input['DOB'],
            'avatar_url'=> $input['avatar_url']??null,
            ]);
            return response()->json([
                'message'=> 'user registered successfully'
                ]);
    }
    public function login(Request $request){
        $request->validate([
            'email'=> ['required','string'],
            'password'=> ['required','string'],

        ]);
        $credentials =request(['email','password']);
        if (!$token=auth('api')->attempt($credentials)) {
            return response()->json([
                'error'=> 'Unauthorized'],404
                );
                
        }
             return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
        
    }
    public function logout(){
        auth('api')->logout(true);
        return response()->json([
            'message'=> 'logout'
            ]);
        }
        public function userinfo(){
            $user = auth('')->user();
            return response()->json([
                'data'=> $user,
                ]);

        }
        public function refresh(){
            $token= auth()->refresh(true,true); //it must be true to force the token to be blacklisted "forever"
            return response()->json([
               'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
                ]);

        }
        public function update(Request $request){
            $request->validate([
                'name'=> ['string'],
                'avatar_url'=>['string'],
            ]);
            auth()->user()->update($request->all());
            return response()->json([
                'message'=> 'update done'
                ]);
                
        }    
        


    
}
