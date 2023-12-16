<?php

namespace App\Observers;

use App\Models\Pharmacy;

class PharmacyObserver
{
    /**
     * Handle the Pharmacy "creating" event.
     */
    public function creating(Pharmacy $pharmacy): void
    {
        //
    }
    /**
     * Handle the Pharmacy "created" event.
     */
    public function created(Pharmacy $pharmacy): void
    {
        //
    }

    /**
     * Handle the Pharmacy "updated" event.
     */
    public function updated(Pharmacy $pharmacy): void
    {
        //
    }

    /**
     * Handle the Pharmacy "deleted" event.
     */
    public function deleted(Pharmacy $pharmacy): void
    {
        //
    }

    /**
     * Handle the Pharmacy "restored" event.
     */
    public function restored(Pharmacy $pharmacy): void
    {
        //
    }

    /**
     * Handle the Pharmacy "force deleted" event.
     */
    public function forceDeleted(Pharmacy $pharmacy): void
    {
        //
    }
}
