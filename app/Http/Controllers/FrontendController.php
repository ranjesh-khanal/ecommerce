<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

// class FrontendController extends Controller
// {
//     public function home()
//     {
//         return view('frontend.home');
//     }
// }
class FrontendController extends Controller
{
    public function home()
    {
        $products = Product::all();
        $banners =Banner::all();
        $categories = Category::all();
        return view('frontend.home',compact('products', 'banners', 'categories'));

    }

    public function detail($slug)
    {
        $categories = Category::all();
        $product = Product::where('slug',$slug)->first();
        return view('frontend.product_detail', compact('product', 'categories'));
    }

    public function productsByCategory($slug)
    {
        $categories = Category::all();
        $category = null;
        if($slug == 'all'){
            $products = Product::all();
        } else {
            $category = Category::where('slug', $slug)->first();
            $products = Product::where('category_id', $category->id)->get();
        }
        return view('frontend.products_by_category', compact('category', 'products', 'categories'));
    }
}

