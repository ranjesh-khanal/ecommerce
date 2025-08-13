<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class CheckoutController extends Controller
{
    public function index()
    {
        $cartItems = $this->getCartItems();
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty');
        }

        $total = $this->calculateTotal($cartItems);
        $addresses = Auth::user()->addresses()->where('type', 'shipping')->get();
        
        return view('frontend.checkout.index', compact('cartItems', 'total', 'addresses'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'shipping_address_id' => 'required|exists:addresses,id',
            'payment_method' => 'required|in:cash_on_delivery,esewa,khalti,ime_pay,connect_ips',
            'notes' => 'nullable|string|max:1000'
        ]);

        $cartItems = $this->getCartItems();
        
        if ($cartItems->isEmpty()) {
            return redirect()->back()->with('error', 'Your cart is empty');
        }

        DB::beginTransaction();
        
        try {
            $order = $this->createOrder($request, $cartItems);
            $this->createOrderItems($order, $cartItems);
            $this->updateStock($cartItems);
            $this->clearCart();
            $this->sendOrderConfirmation($order);

            DB::commit();

            return redirect()->route('order.success', $order->id)->with('success', 'Order placed successfully');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Failed to place order. Please try again.');
        }
    }

    private function createOrder($request, $cartItems)
    {
        $user = Auth::user();
        $address = Address::findOrFail($request->shipping_address_id);
        $subtotal = $this->calculateTotal($cartItems);
        $shipping = 0; // Free shipping for now
        $tax = $subtotal * 0.13; // 13% VAT
        $total = $subtotal + $shipping + $tax;

        return Order::create([
            'user_id' => $user->id,
            'order_number' => 'ORD-' . time() . '-' . strtoupper(uniqid()),
            'shipping_address' => json_encode([
                'name' => $address->name,
                'phone' => $address->phone,
                'email' => $address->email,
                'address' => $address->address_line1 . ', ' . $address->city . ', ' . $address->state . ' ' . $address->zip_code
            ]),
            'subtotal' => $subtotal,
            'shipping' => $shipping,
            'tax' => $tax,
            'total' => $total,
            'payment_method' => $request->payment_method,
            'payment_status' => 'pending',
            'status' => 'pending',
            'notes' => $request->notes
        ]);
    }

    private function createOrderItems($order, $cartItems)
    {
        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'product_name' => $item->product->name,
                'product_image' => $item->product->feature_image,
                'price' => $item->price,
                'quantity' => $item->quantity,
                'total' => $item->price * $item->quantity
            ]);
        }
    }

    private function updateStock($cartItems)
    {
        foreach ($cartItems as $item) {
            $product = Product::find($item->product_id);
            $product->decrement('stock_quantity', $item->quantity);
        }
    }

    private function clearCart()
    {
        $user = Auth::user();
        Cart::where('user_id', $user->id)->delete();
    }

    private function sendOrderConfirmation($order)
    {
        $user = Auth::user();
        
        // Send email to customer
        Mail::to($user->email)->send(new \App\Mail\OrderConfirmation($order));
        
        // Send email to admin
        Mail::to('ranjeshkhanal@gmail.com')->send(new \App\Mail\NewOrderNotification($order));
    }

    private function getCartItems()
    {
        $user = Auth::user();
        return Cart::with('product')->where('user_id', $user->id)->get();
    }

    private function calculateTotal($items)
    {
        return $items->sum(function ($item) {
            return $item->price * $item->quantity;
        });
    }
}
