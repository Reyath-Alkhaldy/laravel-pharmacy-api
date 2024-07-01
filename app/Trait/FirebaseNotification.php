<?php

namespace App\Trait;

use App\Models\Admin;
use App\Models\Doctor;
use App\Models\Pharmacy;
use App\Models\User;
use Google\Client as GoogleClient;
use Illuminate\Support\Facades\Http;

trait FirebaseNotification
{
    public function sendNotificaitonsByFCMTokendevice($order)
    {
        $user  = $order->user;
        $pharmacy  = $order->pharmacy;
        $FCMTokenDevice =  $order->pharmacy->fcmTokenDevice->last()->token;

        $title = "لديك طلب جديد";
        $description =  "لديك طلب جديد من {$user->name}";
        // dd($FCMTokenDevice);
        // $credentialsFilePath = Http::get(asset('json/firebase_fcm.json')); // in server
        $credentialsFilePath = storage_path('app/json/firebase_fcm.json');
        // تحقق من وجود الملف
        if (!file_exists($credentialsFilePath)) {
            return response()->json([
                'message' => 'Credentials file not found'
            ], 500);
        }
        $jsonData = json_decode(file_get_contents($credentialsFilePath), true);
        $client = new GoogleClient();
        $client->setAuthConfig($jsonData);
        $client->addScope('https://www.googleapis.com/auth/firebase.messaging');
        try {
            $client->fetchAccessTokenWithAssertion();
            $token = $client->getAccessToken();
            $access_token = $token['access_token'];
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error fetching access token: ' . $e->getMessage()
            ], 500);
        }

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
                // "data" =>[ $order->medicines->first()],
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
