<?php

namespace App\Trait;

use App\Models\Admin;
use App\Models\Doctor;
use App\Models\Pharmacy;
use App\Models\User;
// use Illuminate\Support\Facades\Hash;
trait GetUser
{
    public function getUser($request)
    {
        $user_type = $request->post('user_type');
        if ($user_type == 1) {
            return User::where('email', $request->email)->first();
        } else if ($user_type == 2) {
            return Doctor::where('email', $request->email)->first();
        } else if ($user_type == 3) {
            return Pharmacy::where('email', $request->email)->first();
        }
        return Admin::where('email', $request->email)->first();
    }
}
