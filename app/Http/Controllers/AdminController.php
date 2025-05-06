<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    // CONTROLLERS FOR BRANDS
    public function brands(){
        $brands = Brand::withCount('products')->orderBy('id', 'desc')->paginate(10);
        return view('admin.brands',compact('brands'));
    }

    public function add_brands(Request $request){
        
        return view('admin.add_brands');
    }

    public function store_brands(Request $request){

        $request->validate([
            'name' => 'required|max:50',
            'slug' => 'required|string|unique:brands,brand_slug',
            'image' => 'required|image|mimes:png,jpg,svg,jpeg,gif',
        ]);

        $brands = new Brand();

        $brands->brand_name = $request->name;
        $brands->brand_slug = Str::slug($request->name);

        if($request->hasFile('image')){
            $image = $request->file('image');

            $imgName = time() . '.' . $image->getClientOriginalExtension();

            $image->move(public_path('uploads/brands/'), $imgName);

            $brands->brand_img = $imgName;
        }

        $brands->save();

        flash()->success('Brand added successfully!');
        return redirect()->route('admin.brands');
    }

    public function edit_brands($id){
        $brands = Brand::findOrFail($id);
        return view('admin.edit_brands', compact('brands'));
    }


    public function update_brands(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:50',
            'slug' => 'required|string|unique:brands,brand_slug,' . $id,
            'image' => 'nullable|image|mimes:png,jpg,svg,jpeg,gif',
        ]);
    
        $brands = Brand::findOrFail($id);
    
        $brands->brand_name = $request->name;
        $brands->brand_slug = Str::slug($request->slug);
    
        if ($request->hasFile('image')) {
            $oldImage = public_path('uploads/brands/' . $brands->brand_img);
            if (file_exists($oldImage)) {
                unlink($oldImage);
            }
    
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/brands/'), $imageName);
    
            $brands->brand_img = $imageName;
        }
    
        $brands->save();
    
        flash()->success('Brand updated successfully!');
        return redirect()->route('admin.brands');
    }
    public function destroy(Request $request, $id){
        $brands = Brand::findOrFail($id);

            $oldImage = public_path('uploads/brands/' . $brands->brand_img);
            if (file_exists($oldImage)) {
                unlink($oldImage);
            }

        $brands->delete();
        return redirect()->route('admin.brands');
    }


    // CONTROLLER FOR CATEGORIES
    public function categories(){
        $categories = Category::withCount('products')->orderBy('id', 'desc')->paginate(10);
        return view('admin.categories', compact('categories'));
    }

    public function add_categories(Request $request){
        
        return view('admin.add_categories');
    }
    public function store_categories(Request $request){

        $request->validate([
            'name' => 'required|max:50',
            'slug' => 'required|string|unique:categories,category_slug',
            'image' => 'required|image|mimes:png,jpg,svg,jpeg,gif',
        ]);

        $categories = new Category();

        $categories->category_name = $request->name;
        $categories->category_slug = Str::slug($request->name);

        if($request->hasFile('image')){
            $image = $request->file('image');

            $imgName = time() . '.' . $image->getClientOriginalExtension();

            $image->move(public_path('uploads/categories/'), $imgName);

            $categories->category_img = $imgName;
        }

        $categories->save();

        flash()->success('Category added successfully!');
        return redirect()->route('admin.categories');
    }

    public function edit_categories($id){
        $categories = Category::findOrFail($id);
        return view('admin.edit_categories', compact('categories'));
    }


    public function update_categories(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:50',
            'slug' => 'required|string|unique:categories,category_slug,' . $id,
            'image' => 'nullable|image|mimes:png,jpg,svg,jpeg,gif',
        ]);
    
        $categories = Category::findOrFail($id);
    
        $categories->category_name = $request->name;
        $categories->category_slug = Str::slug($request->slug);
    
        if ($request->hasFile('image')) {
            $oldImage = public_path('uploads/categories/' . $categories->category_img);
            if (file_exists($oldImage)) {
                unlink($oldImage);
            }
    
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/categories/'), $imageName);
    
            $categories->category_img = $imageName;
        }
    
        $categories->save();
    
        flash()->success('Category updated successfully!');
        return redirect()->route('admin.categories');
    }
    public function destroy_categories(Request $request, $id){
        $categories = Category::findOrFail($id);

            $oldImage = public_path('uploads/categories/' . $categories->category_img);
            if (file_exists($oldImage)) {
                unlink($oldImage);
            }

        $categories->delete();
        return redirect()->route('admin.categories');
    }





    // CONTROLLER FOR USER

    public function userList(){
        $users = User::paginate(10);
        return view('admin.user', compact('users'));
    }
   

    
}
