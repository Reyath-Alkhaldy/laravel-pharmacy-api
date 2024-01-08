<?php

namespace App\Repositories\Cart;

use App\Models\Cart;
use App\Models\Medicine;
// use Auth;

/**
 * CartModelRepository
 */
class CartModelRepository implements CartRepository{
    protected $items ;
    public function __construct()
    {
        $this->items = collect();
    }

    public function get()
    {
        if(!$this->items->count()){

            $this->items = Cart::with("medicine")->get();
        }
        return $this->items;
    }
    public function add(Medicine $medicine,$quantity = 1 ){
        $item = Cart::where('medicine_id',"=",$medicine->id)->first();

        if(!$item){
            $cart = Cart::create([
                'user_id' => \Auth::id(),
                'medicine_id' => $medicine->id,
                'pharmacy_id' => $medicine->pharmacy_id,
                'quantity' => $quantity,
            ]);
            $this->get()->push($cart);
            return $cart;
        }
        // dd($item);
        return $item->increment('quantity',$quantity);

    }
    public function update($id, $quantity){
          Cart::where('id',$id)
        ->update(['quantity' => $quantity]);
    }
    public function delete($id){
          Cart::where('medicine_id',$id)
          ->delete();
    }
    public function deleteByPharmacyId($id){
        Cart::where('pharmacy_id',$id)
        ->delete();
  }
    public function empty(){
        Cart::query()->delete();

    }
    public function total(): float
    {
        return $this->get()->sum(function($item){
            return (float)  $item->quantity * $item->medicine->price;

        });

    /*  return (float)  Cart::join('medicines','medicines.id',"=",'carts.medicine_id')
        ->selectRaw('sum(medicines.price * carts.quantity) as total')
        ->value('total');
     */
    }



}
