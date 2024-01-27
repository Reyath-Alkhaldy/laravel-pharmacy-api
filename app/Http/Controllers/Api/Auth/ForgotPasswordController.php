<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Doctor;
use App\Models\Pharmacy;
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
        $user_type = $request->input('user_type');
        $request->validate([
            'email' => ['required', 'email', 'max:255'],
            'user_type' => [
                'required', 'max:1',
                // $user_type == 1 ? Rule::unique(User::class, 'email') :
                //     $user_type == 2 ? Rule::unique(Doctor::class, 'email') :
                //     $user_type == 3 ? Rule::unique(Pharmacy::class, 'email') :
                //     Rule::unique(Admin::class, 'email'),
            ],
        ]);
        $user = $this->getUser($request,'email');
        $user->notify(new ResetPasswordNotificatin);
        return response()->json([
            'status' => 'success',
        ]);
    }
}
