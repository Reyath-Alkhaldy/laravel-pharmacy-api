<?php

namespace App\Http\Controllers\Api;

use App\Events\OrderCreated;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderMedicine;
use App\Repositories\Cart\CartRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckOutController extends Controller
{
    protected $cart ;
    /**
     * __construct.
     */
    public function __construct(CartRepository $cart){
        $this->cart = $cart;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $cart = $this->cart->get();
       return  Order::with('orderMedicines')->get();
       
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request,CartRepository $cart)
    {   // $request->validate([
        //     'addr.billing.first_name'=> ['required','string','max:255'],
        //     'addr.billing.last_name'=> ['required','string','max:255'],
        //     'addr.billing.email'=> ['required','string','max:255'],
        //     'addr.billing.city'=> ['string','max:255'],
        //     'addr.billing.phone_number'=> ['string','max:255'],
        // ]);
        $items = $cart->get()->where('medicine.pharmacy_id',$request->input('pharmacy_id'))
                      ->groupBy('pharmacy_id')->all();
        DB::beginTransaction();

        $order = collect();
        try {
            foreach ($items as $pharmacy_id => $cart_items) {
                $order  = Order::create([
                    'pharmacy_id' => $pharmacy_id,
                    'user_id' =>Auth::id(),
                ]);

                foreach($cart_items as $item){
                // $orderMedicine =
                 OrderMedicine::create([
                        'order_id' =>$order->id,
                        'medicine_id' =>$item->medicine_id,
                        'medicine_name' =>$item->medicine->name_en,
                        'price' =>$item->medicine->price,
                        'quantity' =>$item->quantity,
                    ]);
                    //   $orderMedicine->medicine->decrement('quantity',$orderMedicine->medicine->pivot->quantity);
                }
                // return $order->medicines;
                $order->addresses()->create([
                    'email' => $order->pharmacy->email,
                    'phone_number' => $order->pharmacy->phone_number,
                    'city' => $order->pharmacy->city->name,
                    'street_address' => $order->pharmacy->address,
                ]);
            }

                // event('order.created',$order,Auth::user());
                event(new OrderCreated($order));
                DB::commit();

        } catch (\Throwable $e) {

            DB::rollback();
            throw $e;
        }
        // return redirect()->route('home');

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
