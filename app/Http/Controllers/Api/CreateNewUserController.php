<?php

namespace App\Http\Controllers\Api;

use App\Actions\Fortify\PasswordValidationRules;
use App\Notifications\EmailVerificationNotificatin;
use App\Trait\UserProcesses;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Http\Request;

class CreateNewUserController extends Controller
{
    use PasswordValidationRules, UserProcesses;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $request
     */
    public function create(RegisterRequest $request)
    {
        $user = $this->ceateUser($request);
        if ($user && Hash::check($request->password, $user->password)) {
            $device_name = $request->post("device_name", $request->userAgent());
            $user->notify(new EmailVerificationNotificatin());
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
}
