<?php

namespace App\Http\Controllers\Api\User\Auth;

use App\Notifications\EmailVerificationNotificatin;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;

class CreateNewUserController extends Controller
{
    /**
     * Validate and create a newly registered user.
     *
     * @param  RegisterRequest  $request
     */
    public function create(RegisterRequest $request)
    {
        $user =  User::create($request->validated());
        if ($user && Hash::check($request->password, $user->password)) {
            $device_name = $request->post("device_name", $request->userAgent());
            $user->notify(new EmailVerificationNotificatin());
            $token = $user->createToken($device_name);
            return response()->json([
                'status' => 'success',
                "token" => $token->plainTextToken,
                'user' => $user,
            ]);
        }
        return response()->json([
            'status' => 'invalid',
            "message" => "invalid credentials",
        ], 200);
    }
}
