<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function userlist(Request $request)
    {
        $users = User::all();
        return response()->json(['status' => 1, 'message'=>'User List', 'user'=>$users]);
    }
}
