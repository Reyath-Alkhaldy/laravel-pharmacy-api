<?php

namespace App\Http\Controllers\Api\Doctor\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Doctor;
use App\Trait\GetUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;

class AccessTokensDoctorController extends Controller
{
    use GetUser;
    public function store(LoginRequest $request)
    {
        $doctor = Doctor::where('phone_number', $request->input('phone_number'))->first();
        if ($doctor && Hash::check($request->password, $doctor->password)) {
            $device_name = $request->post("device_name", $request->userAgent());
            $doctor->tokens()->delete();
            $token = $doctor->createToken($device_name);
            return response()->json([
                'status' => 'success',
                "token" => $token->plainTextToken,
                "doctor" => $doctor,
            ]);
        }
        return response()->json([
            'status' => 'valid',
            "message" => "invalid credentials",
        ], 200);
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
