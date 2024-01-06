<?php

namespace App\Repositories\Cart;
use App\Models\Medicine;
interface CartRepository {

    public function get();
    public function add(Medicine $medicine,$quantity = 1);
    public function update($id, $quantity);
    public function delete($id);
    public function empty();
    public function total();

}
