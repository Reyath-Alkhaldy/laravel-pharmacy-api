<?php

namespace App\Http\Controllers\Api\Doctor\Auth;

use App\Actions\Fortify\PasswordValidationRules;
use App\Http\Controllers\Controller;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Otp;
// use Hash;

class ResetPasswordDoctorController extends Controller
{
    use PasswordValidationRules;

    private $otp;
    public function __construct()
    {
        $this->otp = new Otp;
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required', 'string', 'max:255',  $this->passwordRules()],
            'otp' => ['required', 'string'],
        ]);
        $otp = $this->otp->validate($request->email, $request->otp);
        if (!$otp->status) {
            return response()->json([
                'status' => 'vaild',
            ]);
        }

        $doctor = Doctor::where('email', $request->input('email'))->first();
        $doctor->update([
            'password' => Hash::make($request->password),
        ]);
        // $doctor->tokens()->delete();
        return response()->json([
            'status' => 'success'
        ]);
    }
}
