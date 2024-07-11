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
        $products = Product::paginate(5);
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
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('admin.product.edit', compact('product', 'categories'));
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'unique:products,name,'.$id],
            'category_id' => ['required'],
            'price' => ['required'],
            'description' => ['required'],
            'feature_image' => ['nullable', 'image', 'mimes:jpeg,jpg,png', 'max:2048'],
        ]);
        if($validator->fails()){
            return redirect()->back()->withInput()->withErrors($validator);
        }
        $product = Product::find($id);
        $oldImage = $product->feature_image;
        $input = $request->except('_token');
        $input['slug'] = Str::slug($request->name);
        if($request->hasFile('feature_image')){
            $imageName = time() . '-' . $request->feature_image->getClientOriginalExtension();
            $input['feature_image'] = $imageName;
            if(!file_exists('images/products')){
                mkdir('images/products', 0777, true);
            }
            $request->feature_image->move('images/products', $imageName);
            if(file_exists('images/products/'.$oldImage)){
                unlink('images/products/'.$oldImage);
            }
           
        } else {
            $input['feature_image'] = $oldImage;
        }
        $product->update($input);
        return redirect()->route('product.index')->with('success', 'Product updated successfully');
    }
    public function delete($id)
    {
        $product = Product::find($id);
        $oldImage = $product->feature_image;
        $product->delete();
        if(file_exists('images/products/'.$oldImage)){
            unlink('images/products/'.$oldImage);
        }
        return redirect()->route('product.index');
    }

}
