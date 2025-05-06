<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function cart(){
        return view('pages.cart');
    }

    public function checkout(){
        return view('pages.check-out');
    }

    public function orderConfirmation(){
        return view('pages.order-confirmation');
    }
}
