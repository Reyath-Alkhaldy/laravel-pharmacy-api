<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MarkNotificationAsReadMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $notificationId = $request->input('notification_id');
        if($notificationId){
            $user = $request->user();
            $notification = $user->uneadNotifications()->find($notificationId);
            if($notification){
                $notification->markAsRead();
            }
        }
        return $next($request);
    }
}
