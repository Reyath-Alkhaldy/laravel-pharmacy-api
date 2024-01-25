<?php

namespace App\Http\Controllers\Api;

use App\Actions\Fortify\PasswordValidationRules;
use App\Models\Pharmacy;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\Admin;
use App\Models\Doctor;
use Illuminate\Http\Request;

class CreateNewUserController extends Controller
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $request
     */
    public function create(RegisterRequest $request)
    {
        $user = $this->getUser($request);
        if ($user && Hash::check($request->password, $user->password)) {
            $device_name = $request->post("device_name", $request->userAgent());
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
            return User::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'phone_number' => $request['phone_number'],
                'password' => Hash::make($request['password']),
            ]);
        } else if ($user_type == 2) {
            return Doctor::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'phone_number' => $request['phone_number'],
                'password' => Hash::make($request['password']),
            ]);
        } else if ($user_type == 3) {
            return Pharmacy::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'phone_number' => $request['phone_number'],
                'password' => Hash::make($request['password']),
            ]);
        }
        return Admin::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'phone_number' => $request['phone_number'],
            'password' => Hash::make($request['password']),
        ]);
    }
}
