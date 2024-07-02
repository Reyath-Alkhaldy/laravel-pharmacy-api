<?php
// app/Services/NotificationService.php

namespace App\Services;

use GuzzleHttp\Client;

class NotificationService
{
    protected $httpClient;
    protected $googleClient;

    public function __construct(GoogleClientService $googleClientService)
    {
        $this->httpClient = new Client();
        $this->googleClient = $googleClientService->getClient();
    }

    public function sendPushNotification($deviceToken, $title, $body, $data = null)
    {
        $url = 'https://fcm.googleapis.com/v1/projects/admin-and-pharmacy/messages:send';

        $accessToken = $this->googleClient->fetchAccessTokenWithAssertion()['access_token'];

        $notification = [
            'message' => [
                'token' => $deviceToken,
                'notification' => [
                    'title' => $title,
                    'body' => $body,
                ],
                'data' => $data,
            ],
        ];

        $response = $this->httpClient->post($url, [
            'headers' => [
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json',
            ],
            'json' => $notification,
        ]);

        return json_decode($response->getBody(), true);
    }
}
