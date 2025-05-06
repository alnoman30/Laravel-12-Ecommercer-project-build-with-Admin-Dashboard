<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function cart(){

        $items = Cart::instance('cart')->content();
        return view('pages.cart', compact('items'));
    }

    public function add_to_cart(Request $request)
{
    // Get product from the database
    $product = Product::find($request->id);

    // Check if the product exists
    if ($product) {
        // Add product to the cart
        Cart::instance('cart')->add(
            $product->id,
            $product->name,
            $request->quantity,
            $product->sale_price ?? $product->regular_price,
           
        )->associate(Product::class); // Associate the model
    }

    // Redirect back to the previous page
    return redirect()->back();
}
    public function checkout(){
        return view('pages.check-out');
    }

    public function orderConfirmation(){
        return view('pages.order-confirmation');
    }
}
