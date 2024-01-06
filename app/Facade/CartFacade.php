<?php
namespace App\Facade;

use App\Repositories\Cart\CartRepository;
use Illuminate\Support\Facades\Facade;

class CartFacade extends Facade
{
    public static function getFacadeAccessor(){
        return CartRepository::class;
    }
}