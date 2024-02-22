<?php

namespace App\Http\Controllers\Api\User;

use App\Events\OrderCreated;
use App\Http\Controllers\Controller;
use App\Models\Medicine;
use App\Models\Order;
use App\Models\OrderMedicine;
use App\Repositories\Cart\CartRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class CheckOutController extends Controller
{
    protected $cart;
    /**
     * __construct.
     */
    public function __construct(CartRepository $cart)
    {
        $this->cart = $cart;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $orders =  Order::where('user_id',auth()->user()->id)
        // ->with('medicines')
        // ->paginate();
        $orders =  auth()->user()->orders()->paginate();
        $orders = collect($orders)->except('links');

        return response()->json([
            'status' => 'success',
            'data' => $orders,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request,CartRepository $cart)
    public function store(Request $request, CartRepository $cart)
    {
        $data = $request->validate([
            'cart.*.medicine_id' => ['required', 'integer', 'max:255'],
            'cart.*.quantity' => ['required', 'integer', 'max:255'],
            // 'cart.*.price' => ['required'],
            'device_id' => ['required', 'string', 'max:255'],
            'pharmacy_id' => ['required', 'integer', 'max:255'],
        ]);
        DB::beginTransaction();
        // return $cart->get();
        try {
            $order = Order::create([
                'user_id' => Auth::id(),
                'pharmacy_id' => $data['pharmacy_id'],
                'payment_method' => 'cod',
            ]);
            $total = 0.0; #total
            foreach ($data['cart'] as $item) {
                $medicine = Medicine::where('id', $item['medicine_id'])->first();
                $medicine->count > $item['quantity'] ? $medicine->count -= $item['quantity'] : $medicine->count = 0;
                $medicine->save();
                $total += $medicine->price * $item['quantity']; #total
                OrderMedicine::create([
                    'order_id' => $order->id,
                    'medicine_name' => $medicine->name_en,
                    'medicine_id' => $item['medicine_id'],
                    'quantity' => $item['quantity'],
                    'price' => $medicine->price,
                ]);
            }
            $order->total = $total; #total
            $order->save(); #total
            $order->load('pharmacy');
            // ! event OrderCreated with listeners
            event(new OrderCreated($order));
            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'The order was created',
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            // throw $th;
            return response()->json([
                'status' => 'valid',
                'message' => $th->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // return  Order::where('id',$id)->with('orderMedicines:id,name_en,name_ar,price,pharmacy_id')->get();
        $orders =  Order::where('id', $id)->with('medicines')->get();
        return response()->json([
            'status' => 'success',
            'order' => $orders,
        ]);
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
