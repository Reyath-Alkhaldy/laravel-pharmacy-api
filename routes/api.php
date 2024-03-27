<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
// Route::post('/api/v1/notifications', function (Request $request) {
//     $this->validate($request, [
//         'user_id' => 'required|integer',
//         'message' => 'required|string',
//     ]);

//     $userId = $request->get('user_id');
//     $message = $request->get('message');

//     // Optionally, create a notification object
//     $notification = Notification::create([
//         'user_id' => $userId,
//         'message' => $message,
//     ]);

//     // Broadcast the notification data
//     Broadcast::channel("App.User.$userId")->broadcast(new NotificationBroadcast([
//         'message' => $message,  // Or relevant data from the notification
//     ]));

//     return response()->json(['message' => 'Notification sent'], 201);
// });

require __DIR__.'./pharmacyApi.php';
require __DIR__.'/doctorApi.php';
require __DIR__.'/userApi.php';
