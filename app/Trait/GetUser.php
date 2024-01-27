<?php

namespace App\Trait;

use App\Models\Admin;
use App\Models\Doctor;
use App\Models\Pharmacy;
use App\Models\User;
// use Illuminate\Support\Facades\Hash;
trait GetUser
{
    public function getUser($request,$imput)
    {
        $user_type = $request->post('user_type');
        if ($user_type == 1) {
            return User::where($imput, $request->input($imput))->first();
        } else if ($user_type == 2) {
            return Doctor::where($imput, $request->input($imput))->first();
        } else if ($user_type == 3) {
            return Pharmacy::where($imput, $request->input($imput))->first();
        }
        return Admin::where($imput, $request->input($imput))->first();
    }
}
