<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function products(){
        $products = Product::with(['category', 'brand'])->orderBy('id', 'desc')->paginate(10);
        return view('admin.products', compact('products'));
    }

    public function add_products(){

        $categories = Category::select('id', 'category_name')->orderBy('category_name')->get();
        $brands = Brand::select('id', 'brand_name')->orderBy('brand_name')->get();
        
    
        return view('admin.add_products', compact('categories', 'brands'));
    }


    public function store_products(Request $request){

        $request->validate([
            'name' => 'required|max:200',
            'slug' => 'required|unique:products,slug',
            'short_description' => 'nullable',
            'description' => 'required',
            'regular_price' => 'required|numeric',
            'sale_price' => 'nullable|numeric',
            'sku' => 'required',
            'stock_status' => 'required|in:instock,outofstock',
            'featured' => 'required|boolean',
            'quantity' => 'required| integer',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp,jfif|max:3000',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp,jfif|max:3000',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
        ]);

        // create product
        $product = new Product();
        $product->name = $request->name;
        $product->slug = Str::slug($request->name);
        $product->short_description = $request->short_description;
        $product->description = $request->description;
        $product->regular_price = $request->regular_price;
        $product->sale_price = $request->sale_price;
        $product->sku = $request->sku;
        $product->stock_status = $request->stock_status;
        $product->featured = $request->featured;
        $product->quantity = $request->quantity;
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;
        $current_timestamp = Carbon::now()->timestamp;

        if($request->hasFile('image'))
        {
            $image = $request->file('image');
            $imageName = $current_timestamp . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/products/'), $imageName);
            $product->image = $imageName; 
        }

        $galleryImages = [];

        if($request->hasFile('images'))
        {
            foreach($request->file('images') as $image){
                $imageName = uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/products/gallery/'), $imageName);
                $galleryImages[] = 'uploads/products/gallery/' . $imageName;
                
            }
        }


        $product->gallery_images = json_encode($galleryImages); // Stored as JSON array
        $product->save();

        return redirect()->route('admin.products');
    }

    public function edit_products ( $id){

        $products = Product::findOrFail($id);
        $categories = Category::select('id', 'category_name')->orderBy('category_name')->get();
        $brands = Brand::select('id', 'brand_name')->orderBy('brand_name')->get();
        return view('admin.edit_products', compact('products', 'categories', 'brands'));
    }

    public function destroy_products($id){
        $products = Product::findOrFail($id);

        $products->delete();
        return redirect()->route('admin.products');
    }

    public function products_details($product_slug){
        $products = Product::where('slug', $product_slug )->first();
        $relatedProducts = Product::where('slug', '<>', $product_slug )->get()->take(8);
        return view('pages.details', compact('products', 'relatedProducts'));
    }

}
