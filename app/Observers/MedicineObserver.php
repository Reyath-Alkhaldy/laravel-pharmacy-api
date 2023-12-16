<?php

namespace App\Observers;

use App\Models\Medicine;

class MedicineObserver
{
    /**
     * Handle the Medicine "created" event.
     */
    public function created(Medicine $medicine): void
    {
        //
    }

    /**
     * Handle the Medicine "updated" event.
     */
    public function updated(Medicine $medicine): void
    {
        //
    }

    /**
     * Handle the Medicine "deleted" event.
     */
    public function deleted(Medicine $medicine): void
    {
        //
    }

    /**
     * Handle the Medicine "restored" event.
     */
    public function restored(Medicine $medicine): void
    {
        //
    }

    /**
     * Handle the Medicine "force deleted" event.
     */
    public function forceDeleted(Medicine $medicine): void
    {
        //
    }
}
