<?php

namespace App\Http\Controllers\Api\User\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\ResetPasswordNotificatin;
use App\Trait\GetUser;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ForgotPasswordController extends Controller
{
    use GetUser;
    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'max:255'],
        ]);
        $user = User::where('email', $request->input('email'))->first();
        $user->notify(new ResetPasswordNotificatin);
        return response()->json([
            'status' => 'success',
        ]);
    }
}
