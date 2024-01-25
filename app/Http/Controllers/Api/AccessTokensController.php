<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Doctor;
use App\Models\Pharmacy;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Laravel\Sanctum\PersonalAccessToken;

class AccessTokensController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            "email" => [
                "required", "string", "email", "max:255",
                Rule::unique(User::class),
                Rule::unique(Admin::class),
                Rule::unique(Doctor::class),
                Rule::unique(Pharmacy::class)
            ],
            "password" => "required|string|min:6",
            "device_name" => "string|max:255",
            'user_type' => "required|integer",
            // "abilities" => "nullable|array",
        ]);
        $user = $this->getUser($request);
        if ($user && Hash::check($request->password, $user->password)) {
            $device_name = $request->post("device_name", $request->userAgent());
            // $token = $user->createToken($device_name, $request->post("abilities"));
            $token = $user->createToken($device_name);
            return response()->json([
                "token" => $token->plainTextToken,
                "user" => $user,
            ]);
        }
        return response()->json([
            "message" => "invalid credentials",
        ], 401);
    }
    private function getUser($request)
    {
        $user_type = $request->post('user_type');
        if ($user_type == 1) {
            return  User::where("email", $request->email)->first();
        } else if ($user_type == 2) {
            return  Doctor::where("email", $request->email)->first();
        } else if ($user_type == 3) {
            return  Pharmacy::where("email", $request->email)->first();
        }
        return  Admin::where("email", $request->email)->first();
    }
    

    public function  destroy($token = null)
    {
        $user = Auth::user();
        if ($token === null) {
            $user->currentAccessToken()->delete();
            return [
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
                'messge' => $personalAccessToken->plainTextToken,
            ];
        }
    }
}
