<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $notifications = $user->notifications()->where('data->doctor_id',9)->paginate();
        $unreadNotifications = $user->unreadNotifications()->count();
        $readNotifications = $user->readNotifications()->count();
        $notifications = collect($notifications)->except('links');

        return response()->json([
            'status' => 'success',
            'unreadNotifications' =>  $unreadNotifications,
            'readNotifications' =>  $readNotifications,
            'notifications' =>  $notifications,
        ]);
    }
    /**
     * Display a listing of the readNotifications.
     */
    public function readNotifications()
    {
        $user = Auth::user();
        return $user->readNotifications;
    }
    /**
     * Display a listing of the resource.
     */
    public function unreadNotifications()
    {
        $user = Auth::user();
        return $user->unreadNotifications;
    }

    public function markAsRead(Request $request)
    {
        $user = Auth::user();
        // $user->unreadNotifications()->where('notifiable_type', )
        // $user->unreadNotifications->markAsRead();
        // $user->unreadNotifications()->update(['read_at' => now()]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
