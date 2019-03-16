<?php

namespace App\Http\Controllers;

use App\Entities\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function signup(Request $request)
    {

        $request->validate([
            'name'     => 'required|string',
            'email'    => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed',
            'rol'      => 'required'
        ]);

        $user = new User([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
            'rol'      => $request->rol
         ]);
        $user->save();
        return response()->json($this->getToken($user), 201);
    }

    private function getToken($user){
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        $token->save();
        return[
            'access_token' => $tokenResult->accessToken,
            'rol'          => $user->rol,
            'token_type'   => 'Bearer',
            'id'           => $user->id,
            'expires_at'   => Carbon::parse(
                $tokenResult->token->expires_at)
                ->toDateTimeString()];
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'       => 'required|string|email',
            'password'    => 'required|string',
        ]);
        $credentials = request(['email', 'password']);
        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Unauthorized'], 401);
        }
        return response()->json($this->getToken($request->user()), 200);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json(['message' =>
            'Successfully logged out']);
    }

    public function user(Request $request)
    {
        return response()->json($request->user());
    }
}