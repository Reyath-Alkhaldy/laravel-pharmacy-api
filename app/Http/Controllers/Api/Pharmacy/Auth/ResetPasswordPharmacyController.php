<?php

namespace App\Http\Controllers\Api\Pharmacy\Auth;

use App\Actions\Fortify\PasswordValidationRules;
use App\Http\Controllers\Controller;
use App\Models\Pharmacy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Otp;
// use Hash;

class ResetPasswordPharmacyController extends Controller
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
                'status' => 'invalid',
            ]);
        }

        $pharmacy = Pharmacy::where('email', $request->input('email'))->first();
        $pharmacy->update([
            'password' => Hash::make($request->password),
        ]);
        // $doctor->tokens()->delete();
        return response()->json([
            'status' => 'success'
        ]);
        // newww
    }
}
