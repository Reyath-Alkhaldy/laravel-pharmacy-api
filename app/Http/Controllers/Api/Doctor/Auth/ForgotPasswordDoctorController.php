<?php

namespace App\Http\Controllers\Api\Doctor\Auth;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Notifications\ResetPasswordNotificatin;
use App\Trait\GetUser;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ForgotPasswordDoctorController extends Controller
{
    use GetUser;
    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'max:255'],
        ]);
        $doctor = Doctor::where('email', $request->input('email'))->first();
        $doctor->notify(new ResetPasswordNotificatin);
        return response()->json([
            'status' => 'success',
        ]);
    }
}
