<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        $res = [
            'status' => false,
            'message' => '',
            'data' => []
        ];
        if(Auth::attempt(['username' => request('username'),'password' => request('password')])){
            $user = Auth::user();
            $res['status'] = true;
            $res['message'] = "Login Berhasil";
            $res['data']['token'] = "Bearer ".$user->createToken("web_".request('username'))->accessToken;
            return response()->json($res,200);
        }
        $res['message'] = 'Unauthorized';
        return response()->json($res,401);
    }

    public function profil()
    {
        $user = Auth::user();
        $user = $user->makeHidden(['email_verified_at','password','remember_token']);
        $res = [
            'status' => true,
            'message' => 'Berhasil mengambil data user',
            'data' => $user
        ];
        return response()->json($res,200);
    }

}
