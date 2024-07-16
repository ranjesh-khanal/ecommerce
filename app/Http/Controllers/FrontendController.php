<?php

namespace App\Http\Controllers;

use App\Models\Banner;
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
        return view('frontend.home',compact('products', 'banners'));

    }

    public function detail($slug)
    {
        $product = Product::where('slug',$slug)->first();
        return view('frontend.product_detail', compact('product'));
    }
}

