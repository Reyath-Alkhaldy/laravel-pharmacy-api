<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Medicine;
use App\Repositories\Cart\CartModelRepository;
use App\Repositories\Cart\CartRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class CartController extends Controller
{
    protected $cart ;
    /**
     * Display a listing of the resource.
     */
    public function __construct(CartRepository $cart){
        $this->cart = $cart;
    }

    public function index( )
    {
        return  [
            'cart'=> $this->cart->get(),
        ];
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            // 'medicine_id'=>['required','int','exists:medicines,id'],
            'medicine_id'=>['required','int'],
            'device_id'=>['required'],
            'quantity' =>['nullable','int','min:1']
        ]);

        $medicine = Medicine::findOrfail($request->post('medicine_id'));

        $this->cart->add($medicine,$request->post('quantity'));

        if($request->acceptsJson()){
            return response()->json([
                'message' => 'medicine added to cart',
                // 'cart' => $this->cart
            ],201);
        }
        return [
            'success' => 'medicine added to cart',
        ];
        // return redirect()->route('cart.index')->with('success','medicine added to cart');
    }




    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $request->validate([
            'quantity' =>['required','int','min:1']
        ]);
        $this->cart->update($id,$request->post('quantity'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->cart->delete($id);
        Cart::destroy($id);
        return [
            'message'=> 'item delete success'
        ];
    }
}
