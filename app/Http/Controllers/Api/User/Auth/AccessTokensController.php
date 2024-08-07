<?php

namespace App\Http\Controllers\Api\User\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;

class AccessTokensController extends Controller
{
    public function store(LoginRequest $request)
    {
        $user = User::where('phone_number', $request->input('phone_number'))->first();
        if ($user && Hash::check($request->password, $user->password)) {
            $device_name = $request->post("device_name", $request->userAgent());
            // $user->tokens()->delete();
            $token = $user->createToken($device_name);
            $this->storeFCMTokendevice($user, $device_name, $request);
            return response()->json([
                'status' => 'success',
                "token" => $token->plainTextToken,
                "user" => $user,
                'email_verified_at' => $user->email_verified_at,
            ]);
        }
        return response()->json([
            'status' => 'invalid',
            "message" => "invalid credentials",
        ], 200);
    }



    public function  destroy($token = null)
    {
        $user = Auth::guard('sanctum')->user();
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
