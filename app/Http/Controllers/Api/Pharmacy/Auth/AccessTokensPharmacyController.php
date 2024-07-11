<?php

namespace App\Http\Controllers\Api\Pharmacy\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pharmacy\Auth\LoginPharmacyRequest;
use App\Models\Pharmacy;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;

class AccessTokensPharmacyController extends Controller
{
    public function store(LoginPharmacyRequest $request)
    {

        $pharmacy = Pharmacy::where('email', $request->input('email'))->first();
        // return $pharmacy->fcmTokenDevice()->where("id", ">",10)->get();
        if ($pharmacy && Hash::check($request->password, $pharmacy->password)) {
            $device_name = $request->post("device_name", $request->userAgent());
            // $doctor->tokens()->delete();
            $token = $pharmacy->createToken($device_name);
            $this->storeFCMTokendevice($pharmacy, $device_name, $request);
            return response()->json([
                'status' => 'success',
                "token" => $token->plainTextToken,
                "pharmacy" => $pharmacy,
            ]);
        }
        return response()->json([
            'status' => 'invalid',
            "message" => "invalid credentials, Email Or Password Not Correct",
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
