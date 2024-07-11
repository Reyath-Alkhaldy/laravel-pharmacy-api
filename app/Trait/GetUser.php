<?php

namespace App\Trait;

use App\Models\Admin;
use App\Models\Doctor;
use App\Models\Pharmacy;
use App\Models\User;
use Google\Client as GoogleClient;
use Illuminate\Support\Facades\Http;

trait GetUser
{
    public function getUser($request, $imput)
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

    public function  storeFCMTokendevice($user,$device_name,$request)
    {
        return    $user->fcmTokenDevice()->create([
            "device"=> $device_name,
            'token' => $request->post('fcm_token_device'),
           ]);

    }
    // $CURLOPT_URL = 'https://fcm.googleapis.com/v1/projects/admin-and-pharmacy/messages:send';

    public function sendNotifyByFCMTokendevice($FCMTokenDevice)
    {
        $title = "اشعار جديد";
        $description = "تيست تيست تيست";

        // $credentialsFilePath = Http::get(asset('json/firebase_fcm.json')); // in server
        $credentialsFilePath = storage_path('app/json/firebase_fcm.json');
        // تحقق من وجود الملف
        if (!file_exists($credentialsFilePath)) {
            return response()->json([
                'message' => 'Credentials file not found'
            ], 500);
        }
        // return $credentialsFilePath;

         $jsonData = json_decode(file_get_contents($credentialsFilePath), true);
        $client = new GoogleClient();
        // $client->useApplicationDefaultCredentials();
        $client->setAuthConfig($jsonData);
        $client->addScope('https://www.googleapis.com/auth/firebase.messaging');

        // return $client->refreshTokenWithAssertion(); 
        try {
            $client->fetchAccessTokenWithAssertion();
            $token = $client->getAccessToken();
            $access_token = $token['access_token'];
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error fetching access token: ' . $e->getMessage()
            ], 500);
        }



        // $access_token = $token['access_token'];

        $headers = [
            "Authorization: Bearer $access_token",
            'Content-Type: application/json'
        ];

        $data = [
            "message" => [
                "token" => $FCMTokenDevice,
                "notification" => [
                    "title" => $title,
                    "body" => $description,
                ],
            ]
        ];
        $payload = json_encode($data);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/v1/projects/admin-and-pharmacy/messages:send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_VERBOSE, true); // Enable verbose output for debugging
        $response = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);

        if ($err) {
            return response()->json([
                'message' => 'Curl Error: ' . $err
            ], 500);
        } else {
            return response()->json([
                'message' => 'Notification has been sent',
                'response' => json_decode($response, true)
            ]);
        }
    }
}
// 7 - Response : 
// {
//     "message": "Notification has been sent",
//     "response": {
//         "name": "projects/project_id/messages/0:1716964946123652%49b35ce849b35ce8"
//     }
// }
// notification is send successfully