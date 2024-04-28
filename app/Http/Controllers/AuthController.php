<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use JWTAuth;

class AuthController extends Controller
{
     /* Register API */
     public function register(Request $request)
     {
        $validator = Validator::make($request->all(),
            [
                'name'=>'required|string|max:255',
                'email'=>'required|string|email|max:255|unique:users',
                'password'=>'required|string|min:6',
                // 'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]
        );

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $path = public_path('images/');
            $request->image->move($path, $imageName);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'image' => $imageName
            
        ]);

        // $token = $user->createToken('authToken')->plainTextToken;
        $token = JWTAuth::fromUser($user);

        return response()->json([
            'status' => 1,
            'message'=>'User Registered Successfully',
            'user'=>$user,
            'authorisation'=> [
                'token' => $token,
                'type' => 'bearer'
            ]
        ]);
    }


     /* Login API */
     public function login(Request $request)
     {
        $validator = Validator::make($request->all(),
            [
                'email'=>'required|string|email',
                'password'=>'required|string'
            ]
        );

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $cridentials = $request->only('email', 'password');

        $token = Auth::attempt($cridentials);
        
        if(!$token){
            return response()->json([
                'status'=>'error',
                'message'=>'unauthorized'
            ], 401);
        }

        $user = Auth::user();
        return response()->json([
            'status'=> 1,
            'user'=> $user,
            'authorisation'=> [
                'token' => $token,
                'type' => 'bearer'
            ]
        ]);
     }

     /*User Detail API */
    public function userDetails()
    {
        return response()->json(auth()->user());
    }
}
