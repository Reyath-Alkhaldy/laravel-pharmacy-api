<?php

namespace App\Http\Controllers\Api\User\Auth;

use App\Actions\Fortify\PasswordValidationRules;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Otp;
// use Hash;

class ResetPasswordController extends Controller
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

        $user = User::where('email', $request->input('email'))->first();
        $user->update([
            'password' => Hash::make($request->password),
        ]);
        // $user->tokens()->delete();
        return response()->json([
            'status' => 'success'
        ]);

    }
}
