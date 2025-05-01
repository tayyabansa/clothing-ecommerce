<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Models\Product;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = 0;
        
        foreach($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        
        return view('cart.index', compact('cart', 'total'));
    }

    public function add(Request $request, Product $product)
    {
        $cart = session()->get('cart', []);
        
        if(isset($cart[$product->id])) {
            $cart[$product->id]['quantity']++;
        } else {
            $cart[$product->id] = [
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->price,
                "image" => $product->image_url
            ];
        }
        
        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }

    public function update(Request $request, $id)
    {
        $cart = session()->get('cart', []);
        
        if(isset($cart[$id])) {
            $quantity = max(1, intval($request->quantity)); // Ensure minimum quantity is 1
            $cart[$id]['quantity'] = $quantity;
            session()->put('cart', $cart);
            
            $total = 0;
            foreach($cart as $item) {
                $total += $item['price'] * $item['quantity'];
            }
            
            return response()->json([
                'success' => true,
                'quantity' => $quantity,
                'itemTotal' => number_format($cart[$id]['price'] * $quantity, 2),
                'cartTotal' => number_format($total, 2)
            ]);
        }
        
        return response()->json(['success' => false], 404);
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);
        
        if(isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        
        return redirect()->back()->with('success', 'Product removed from cart successfully!');
    }

    public function checkout()
    {
        $cart = session()->get('cart', []);
        $total = 0;
        
        foreach($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => 'Clothing Store Purchase',
                    ],
                    'unit_amount' => $total * 100,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('checkout.success'),
            'cancel_url' => route('cart.index'),
        ]);

        return redirect($session->url);
    }

    public function success()
    {
        session()->forget('cart');
        return view('checkout.success');
    }
}
