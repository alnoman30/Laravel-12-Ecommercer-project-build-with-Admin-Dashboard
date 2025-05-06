<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    public function Dashboard(){
        if(Auth::id()){
            $usertype = Auth::user()->usertype;
            
            if( $usertype == 'admin'){
                return view('admin.dashboard');
            }
            elseif($usertype == 'user'){
                return view('user.dashboard');
            }
            else{
                return redirect()->route('login');
            }
        }
    }

    public function index(){
        return view('pages.home');
    }

    public function shop(){
        $products = Product::orderBy('created_at', 'DESC')->paginate(10);
        $categories = Category::withCount('products')->orderBy('id', 'desc')->paginate(10);
        $brands = Brand::withCount('products')->orderBy('id', 'desc')->paginate(10);
        return view('pages.shop',compact('products', 'categories', 'brands'));
    }


    public function about(){
        return view('pages.about');
    }


    public function contact(){
        return view('pages.contact');
    }
    public function wishlist(){
        return view('pages.wishlist');
    }
    public function privacy_policy(){
        return view('pages.privacy');
    }
    public function terms_condition(){
        return view('pages.terms_condition');
    }

    
}
