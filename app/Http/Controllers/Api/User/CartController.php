<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Medicine;
use App\Repositories\Cart\CartRepository;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected $cart;
    /**
     * Display a listing of the resource.
     */
    public function __construct(CartRepository $cart)
    {
        $this->cart = $cart;
    }

    public function index()
    {
        return  [
            "status" => "success",
            'carts' => $this->cart->get(),
            'total' => $this->cart->total(),
        ];
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            // 'medicine_id'=>['required','int','exists:medicines,id'],
            'medicine_id' => ['required', 'int'],
            'device_id' => ['required'],
            'quantity' => ['nullable', 'int', 'min:1']
        ]);

        $medicine = Medicine::findOrfail($request->post('medicine_id'));
        $this->cart->add($medicine, $request->post('quantity'));

        if ($request->acceptsJson()) {
            return [
                'message' => 'medicine added to cart',
                "status" => "success",
                'carts' => $this->cart->get(),
                'total' => $this->cart->total(),
            ];
        }
        return [
            "message" => "medicine added to cart",
            "status" => "success",
            'carts' => $this->cart->get(),
            'total' => $this->cart->total(),
        ];
        // return redirect()->route('cart.index')->with('success','medicine added to cart');
    }




    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => ['required', 'int', 'min:1']
        ]);
        $this->cart->update($id, $request->post('quantity'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->cart->delete($id);
        Cart::destroy($id);
        return [
            'message' => 'item delete success',
            "status" => "success",
            'carts' => $this->cart->get(),
            'total' => $this->cart->total(),
        ];
    }
}
