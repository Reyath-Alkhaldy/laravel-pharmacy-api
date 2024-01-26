<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Trait\GetUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Otp;
// use Hash;

class ResetPasswordController extends Controller
{
    use GetUser;
    private $otp;
    public function __construct()
    {
        $this->otp = new Otp;
    }
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'max:255'],
            'user_type' => ['required', 'max:1',],
        ]);
        $otp = $this->otp->validate($request->email, $request->otp);
        if (!$otp->status) {
            return response()->json([
                'status' => 'vaild',
            ]);
        }

        $user = $this->getUser($request);
        $user->update([
            'password' => Hash::make($request->password),
        ]);
        // $user->tokens()->delete();
        return response()->json([
            'status' => 'success',
        ]);

    }
}
