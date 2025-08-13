<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = $this->getCartItems();
        $total = $this->calculateTotal($cartItems);
        
        return view('frontend.cart.index', compact('cartItems', 'total'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($request->product_id);
        
        if (!$product->isInStock()) {
            return response()->json(['message' => 'Product is out of stock'], 400);
        }

        $user = Auth::user();
        $price = $user ? $product->getPriceForUser($user) : $product->price;

        $cartItem = Cart::updateOrCreate(
            [
                'user_id' => $user ? $user->id : null,
                'session_id' => $user ? null : session()->getId(),
                'product_id' => $product->id
            ],
            [
                'quantity' => $request->quantity,
                'price' => $price
            ]
        );

        return response()->json([
            'message' => 'Product added to cart',
            'cart_count' => $this->getCartCount()
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cartItem = $this->getCartItem($id);
        
        if (!$cartItem) {
            return response()->json(['message' => 'Cart item not found'], 404);
        }

        $cartItem->update(['quantity' => $request->quantity]);
        
        return response()->json([
            'message' => 'Cart updated',
            'subtotal' => $cartItem->price * $cartItem->quantity,
            'total' => $this->calculateTotal($this->getCartItems())
        ]);
    }

    public function remove($id)
    {
        $cartItem = $this->getCartItem($id);
        
        if ($cartItem) {
            $cartItem->delete();
        }

        return response()->json([
            'message' => 'Item removed from cart',
            'cart_count' => $this->getCartCount()
        ]);
    }

    private function getCartItems()
    {
        $user = Auth::user();
        
        if ($user) {
            return Cart::with('product')->where('user_id', $user->id)->get();
        } else {
            return Cart::with('product')->where('session_id', session()->getId())->get();
        }
    }

    private function getCartItem($id)
    {
        $user = Auth::user();
        
        if ($user) {
            return Cart::where('user_id', $user->id)->where('id', $id)->first();
        } else {
            return Cart::where('session_id', session()->getId())->where('id', $id)->first();
        }
    }

    private function calculateTotal($items)
    {
        return $items->sum(function ($item) {
            return $item->price * $item->quantity;
        });
    }

    private function getCartCount()
    {
        $user = Auth::user();
        
        if ($user) {
            return Cart::where('user_id', $user->id)->count();
        } else {
            return Cart::where('session_id', session()->getId())->count();
        }
    }
}
