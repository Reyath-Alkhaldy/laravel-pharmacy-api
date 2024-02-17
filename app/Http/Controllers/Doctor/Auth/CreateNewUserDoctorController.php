<?php

namespace App\Http\Controllers\Api\Doctor\Auth;

use App\Notifications\EmailVerificationNotificatin;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\Doctor;

class CreateNewUserDoctorController extends Controller
{
    /**
     * Validate and create a newly registered user.
     *
     * @param  RegisterRequest  $request
     */
    public function create(RegisterRequest $request)
    {
        $doctor =  Doctor::create($request->validated());
        if ($doctor && Hash::check($request->password, $doctor->password)) {
            $device_name = $request->post("device_name", $request->userAgent());
            $doctor->notify(new EmailVerificationNotificatin());
            $token = $doctor->createToken($device_name);
            return response()->json([
                'status' => 'success',
                "token" => $token->plainTextToken,
                'doctor' => $doctor,
            ]);
        }
        return response()->json([
            'status' => 'valid',
            "message" => "invalid credentials",
        ], 200);
    }
}
