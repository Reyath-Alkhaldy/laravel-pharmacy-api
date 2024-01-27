<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Trait\GetUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;

class AccessTokensController extends Controller
{
    use GetUser;
    public function store(LoginRequest $request)
    {
        if ($request->input('user_type') == 1) {
            $user = $this->getUser($request, 'phone_number');
        } else {
            $user = $this->getUser($request, 'email');
        }
        if ($user && Hash::check($request->password, $user->password)) {
            $device_name = $request->post("device_name", $request->userAgent());
            $user->tokens()->delete();
            $token = $user->createToken($device_name);
            return response()->json([
                'status' => 'success',
                "token" => $token->plainTextToken,
                "user" => $user,
                "user_type" => $request->input('user_type'),
            ]);
        }
        return response()->json([
            'status' => 'vaild',
            "message" => "invalid credentials",
        ], 401);
    }



    public function  destroy($token = null)
    {
        $user = Auth::user();
        if ($token === null) {
            $user->currentAccessToken()->delete();
            return [
                'status' => 'success',
                'messge null' => $user->plainTextToken,
            ];;
        }
        $personalAccessToken = PersonalAccessToken::findToken($token);
        // return $personalAccessToken;
        if (
            $user->id == $personalAccessToken->tokenable_id &&
            get_class($user) == $personalAccessToken->tokenable_type
        ) {
            $personalAccessToken->delete();
            return [
                'status' => 'success',
                'messge' => $personalAccessToken->plainTextToken,
            ];
        }
    }
}
