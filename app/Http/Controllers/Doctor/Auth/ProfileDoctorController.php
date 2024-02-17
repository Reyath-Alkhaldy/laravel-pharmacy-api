<?php

namespace App\Http\Controllers\Api\Doctor\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ProfileUpdateRequest;

class ProfileDoctorController extends Controller
{
    public function update(ProfileUpdateRequest $request)
    {
        $user = $request->user();
        $validateData = $request->validated();
        $user->update($validateData);
        $user = $user->refresh();
        return response()->json([
            'status' => 'success',
            'user' => $user,
        ]);
    }
}
