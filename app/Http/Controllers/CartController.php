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
        $product = Product::findOrFail($request->id);
    

        Cart::instance('cart')->add(
            $product->id, 
            $product->name,
            $request->quantity, 
            $request->price, 
           
        )->associate(Product::class);
    
       
        return redirect()->back()->with('success', 'Product added to cart!');
    }

    public function increase_quantity(Request $request, $rowId){
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);
        

        $product = Cart::instance('cart')->get($rowId,);
        $qty = $product->qty + $request->quantity;
        Cart::instance('cart')->update($rowId,$qty);
        return redirect()->back();
    }
    public function decrease_quantity(Request $request, $rowId){

        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Cart::instance('cart')->get($rowId);

        $qty = $product->qty - $request->quantity;
        Cart::instance('cart')->update($rowId,$qty);
        return redirect()->back();
    }

    public function remove_cart_item($rowId){
        Cart::instance('cart')->remove($rowId);

        return redirect()->back()->with('success', 'Product removed from cart!');;
    }
    
    public function checkout(){
        return view('pages.check-out');
    }

    public function orderConfirmation(){
        return view('pages.order-confirmation');
    }
}
