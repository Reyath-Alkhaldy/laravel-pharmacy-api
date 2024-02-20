<?php

namespace App\Observers;

use App\Models\Favorite;
use Illuminate\Support\Str;

class FavoriteObserver
{
    /**
     * Handle the Favorite "creating" event.
     */
    public function creating(Favorite $favorite): void
    {
        $favorite->id = Str::uuid();
        $favorite->device_id = Favorite::getDeviceId();
    }
    /**
     * Handle the Favorite "created" event.
     */
    public function created(Favorite $favorite): void
    {
        //
    }

    /**
     * Handle the Favorite "updated" event.
     */
    public function updated(Favorite $favorite): void
    {
        //
    }

    /**
     * Handle the Favorite "deleted" event.
     */
    public function deleted(Favorite $favorite): void
    {
        //
    }

    /**
     * Handle the Favorite "restored" event.
     */
    public function restored(Favorite $favorite): void
    {
        //
    }

    /**
     * Handle the Favorite "force deleted" event.
     */
    public function forceDeleted(Favorite $favorite): void
    {
        //
    }
}
