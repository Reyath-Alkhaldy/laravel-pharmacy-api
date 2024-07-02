<?php
// app/Services/GoogleClientService.php
namespace App\Services;

use Google_Client;

class GoogleClientService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Google_Client();
        $this->client->setAuthConfig(storage_path('app/json/firebase_fcm.json'));
        $this->client->addScope('https://www.googleapis.com/auth/firebase.messaging');
    }

    public function getClient()
    {
        return $this->client;
    }
}
