<?php

namespace App\Http\Controllers\Api\Pharmacy\Auth;

use App\Http\Controllers\Controller;
use App\Models\Pharmacy;
use App\Notifications\ResetPasswordNotificatin;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ForgotPasswordPharmacyController extends Controller
{
    // use GetUser;
    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'max:255'],
        ]);
        $pharmacy = Pharmacy::where('email', $request->input('email'))->first();
        if ($pharmacy) {
            $pharmacy->notify(new ResetPasswordNotificatin);
            return response()->json([
                'status' => 'success',
            ]);
        }
        return response()->json([
            'status' => 'invalid',
            'message' => "Email Not Correct"
        ]);
    }
}
