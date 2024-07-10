<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::paginate(10);
        return view('admin.product.index', compact('products'))->with('id');
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.product.create', compact('categories'));
    }

    public function store(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'unique:products,name'],
            'category_id' => ['required'],
            'price' => ['required'],
            'description' => ['required'],
            'feature_image' => ['required', 'image', 'mimes:jpeg,jpg,png', 'max:2048'],
        ]);
        if($validator->fails()){
            return redirect()->back()->withInput()->withErrors($validator);
        }
        $input = $request->except('_token');
        $input['slug'] = Str::slug($request->name);
        if($request->hasFile('feature_image')){
            $imageName = time() . '-' . $request->feature_image->getClientOriginalExtension();
            $input['feature_image'] = $imageName;
            if(!file_exists('images/products')){
                mkdir('images/products', 0777, true);
            }
            $request->feature_image->move('images/products', $imageName);
        }
        Product::create($input);
        return redirect()->route('product.index')->with('success', 'Product created successfully');
    }
}
