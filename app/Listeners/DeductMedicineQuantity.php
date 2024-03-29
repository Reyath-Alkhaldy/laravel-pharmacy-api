<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class DeductMedicineQuantity
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderCreated $event): void
    {
        $order = $event->order;
        foreach ($order->medicines as $medicine) {
            // quantity
            $quantity = $medicine->order_medicine->quantity;

            if ($medicine->count > $quantity) {
                $medicine->decrement('count', $quantity);
            } else {
                $medicine->count = 0;
                $medicine->save();
            }
        }
    }
}
