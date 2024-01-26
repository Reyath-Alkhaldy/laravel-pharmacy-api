<?php

namespace App\Trait;

use App\Models\Admin;
use App\Models\Doctor;
use App\Models\Pharmacy;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

trait UserProcesses
{
    public function ceateUser($request)
    {
        $user_type = $request->post('user_type');
        if ($user_type == 1) {
            return $this->creating(new User, $request);
        } else if ($user_type == 2) {
            return $this->creating(new Doctor, $request);
        } else if ($user_type == 3) {
            return $this->creating(new Pharmacy, $request);
        }
        return $this->creating(new Admin, $request);
    }
    private function creating($user, $request)
    {
        return   $user->create([
            'name' => $request['name'],
            'email' => $request['email'],
            'phone_number' => $request['phone_number'],
            'password' => Hash::make($request['password']),
        ]);
    }
    public function updateUser($request)
    {
        $user_type = $request->post('user_type');
        if ($user_type == 1) {
            return $this->updating(new User, $request);
        } else if ($user_type == 2) {
            return $this->updating(new Doctor, $request);
        } else if ($user_type == 3) {
            return $this->updating(new Pharmacy, $request);
        }
        return $this->updating(new Admin, $request);
    }
    private function updating($user, $request)
    {
        return   $user->where('email', $request->email)->update([
            'email_verified_at' => now(),
        ]);
    }
}
