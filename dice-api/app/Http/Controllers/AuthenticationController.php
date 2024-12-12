<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthenticationController extends Controller
{
    public function login(Request $request)
    {
        //dd($request->all());

        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) 
        {
            $token = $user->createToken('API Token')->accessToken;
    
            return response()->json(
            [
                'message' => 'Login successfully done',
                'token' => $token,
                'user'  => $user,
            ]);
        }
    
        return response()->json(['error' => 'Invalid credentials'], 401);
    }

//-----------------------------------------------------------------------------------------------------------------------------------------------------------------

    public function logout(Request $request)
    {
        if (!$request->user()) 
        {
            return response()->json(['error' => 'No authenticated user'], 401);
        }
    
        $token = $request->user()->token();
        
        if ($token) 
        {
            $token->revoke();
            return response()->json(['message' => 'Logout successful'], 200);
        }
    
        return response()->json(['error' => 'Token not found'], 400);
    }
}