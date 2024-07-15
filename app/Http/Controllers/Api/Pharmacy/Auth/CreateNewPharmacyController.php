<?php

namespace App\Http\Controllers\Api\Pharmacy\Auth;
 
use App\Notifications\EmailVerificationNotificatin;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Http\Requests\Pharmacy\Auth\RegisterPharmacyRequest;
use App\Models\Pharmacy;
use App\Models\Specialty;

class CreateNewPharmacyController extends Controller
{
    /**
     * Validate and create a newly registered user.
     *
     * @param  RegisterPharmacyRequest  $request
     */
    public function create(RegisterPharmacyRequest $request)
    {
        $pharmacy =  Pharmacy::create($request->validated());
        if ($pharmacy && Hash::check($request->password, $pharmacy->password)) {
            $device_name = $request->post("device_name", $request->userAgent());
            $pharmacy->notify(new EmailVerificationNotificatin());
            $token = $pharmacy->createToken($device_name);
            $pharmacy =Pharmacy::find($pharmacy->id);
            $this->storeFCMTokendevice($pharmacy, $device_name, $request);
            return response()->json([
                'status' => 'success',
                "token" => $token->plainTextToken,
                'pharmacy' => $pharmacy,
            ]);
        }
        return response()->json([
            'status' => 'invalid',
            "message" => "invalid credentials",
        ], 200);
    }


    public function specialties(){
        $specialties = Specialty::get();
        return response()->json([
            'status' => 'success',
            'specialties' => $specialties,
        ]);
    }
}
