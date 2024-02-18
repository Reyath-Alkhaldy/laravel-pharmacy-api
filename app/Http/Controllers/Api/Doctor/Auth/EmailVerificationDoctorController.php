<?php

namespace App\Http\Controllers\Api\Doctor\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\EmailVerificatinRequest;
use App\Models\Doctor;
use App\Notifications\EmailVerificationNotificatin;
// use Ichtrojan\Otp\Otp;
use Illuminate\Http\Request;
use Otp;

class EmailVerificationDoctorController extends Controller
{
    private $otp;
    public function __construct()
    {
        $this->otp = new Otp;
    }
    public function sendEmailVerification(Request $request)
    {
        $request->user()->notify(new EmailVerificationNotificatin);
        return response()->json([
            'status' => 'success',
        ], 200);
    }
    
    public function emailVerification(EmailVerificatinRequest $request)
    {
        $otp = $this->otp->validate($request->email, $request->otp);
        if (!$otp->status) {
            return response()->json([
                'status' => 'valid',
            ]);
        }
        $doctor = Doctor::where('email', $request->email)->update([
            'email_verified_at' => now(),
        ]);;
        return response()->json([
            'status' => 'success',
            'doctor' => $doctor,
        ], 200);
    }
}
