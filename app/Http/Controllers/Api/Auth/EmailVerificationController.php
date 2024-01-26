<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\EmailVerificatinRequest;
use App\Notifications\EmailVerificationNotificatin;
// use Ichtrojan\Otp\Otp;
use App\Trait\UserProcesses;
use Illuminate\Http\Request;
use Otp;

class EmailVerificationController extends Controller
{
    use UserProcesses;
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
                'status' => 'vaild',
            ]);
        }
        $user = $this->updateUser($request);
        return response()->json([
            'status' => 'success',
            'user' => $user,
        ], 200);
    }
}
