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

    // cart": [
    //     {
    //         "id": "20e58369-940c-4237-9aa2-1062b3f9646b",
    //         "device_id": "d746b843-85cb-4b2d-a503-989e4456caa2",
    //         "user_id": null,
    //         "pharmacy_id": 2,
    //         "medicine_id": 5,
    //         "quantity": 4,
    //         "options": null,
    //         "created_at": "2024-01-07T21:04:57.000000Z",
    //         "updated_at": "2024-01-07T21:04:57.000000Z",
    //         "medicine": {
    //             "id": 5,
    //             "name_en": "Aubrey Jakubowski",
    //             "name_ar": "Adeline Johnson",
    //             "scien_name": "Darren",
    //             "mark_name": "Halvorson",
    //             "price": 417.2,
    //             "discount": 74,
    //             "count": 170,
    //             "description": "Ea quis ex amet explicabo vel rerum iste asperiores ipsum error voluptatem.",
    //             "status": "active",
    //             "sub_category_id": 19,
    //             "pharmacy_id": 2,
    //             "image_url": "https://via.placeholder.com/600x600.png/0099ff?text=quis"
    //         }
    public function get()
    {
        if(!$this->items->count()){

            $this->items = Cart::with("medicine:id,name_ar,name_en,price,count,discount")->get();
        }
        return $this->items;
    }
    public function add(  $medicine,$quantity = 1 ){
        $item = Cart::where('medicine_id',$medicine->id)->first();

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
        return (float) $this->get()->sum(function($item){
            return (float)  $item->quantity * $item->medicine->price;

        });

    /*  return (float)  Cart::join('medicines','medicines.id',"=",'carts.medicine_id')
        ->selectRaw('sum(medicines.price * carts.quantity) as total')
        ->value('total');
     */
    }



}
