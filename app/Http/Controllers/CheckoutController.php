<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = 0;
        
        foreach($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        
        return view('checkout.index', compact('cart', 'total'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string'
        ]);

        $cart = session()->get('cart', []);
        
        if(empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }

        try {
            Stripe::setApiKey(config('services.stripe.secret'));

            // Calculate total amount
            $total = array_reduce($cart, function($carry, $item) {
                return $carry + ($item['price'] * $item['quantity']);
            }, 0);

            // Create line items for Stripe
            $lineItems = [];
            
            foreach($cart as $id => $item) {
                
                $lineItems[] = [
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => $item['name'],
                            'images' => [asset( ltrim($item['image'], '/'))],
                        ],
                        'unit_amount' => intval($item['price'] * 100),
                    ],
                    'quantity' => $item['quantity'],
                ];
            }

            // Create Stripe Checkout Session
            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => $lineItems,
                'mode' => 'payment',
                'success_url' => route('checkout.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('cart.index'),
                'metadata' => [
                    'shipping_address' => $request->shipping_address,
                    'user_id' => Auth::id()
                ]
            ]);

            // Store shipping address in session for later use
            session(['shipping_address' => $request->shipping_address]);

            // Redirect to Stripe Checkout
            return redirect($session->url);

        } catch (\Exception $e) {
            dd($e->getMessage());
            // return back()->with('error', 'An error occurred while processing your payment. Please try again.');
        }
    }

    public function success(Request $request)
    {
        try {
            Stripe::setApiKey(config('services.stripe.secret'));
            
            $session = Session::retrieve($request->get('session_id'));
            
            if ($session->payment_status === 'paid') {
                // Create the order
                $order = Order::create([
                    'user_id' => Auth::id(),
                    'total_amount' => $session->amount_total / 100, // Convert from cents
                    'status' => 'completed',
                    'shipping_address' => session('shipping_address'),
                    'payment_method' => 'stripe',
                    'payment_intent_id' => $session->payment_intent
                ]);

                // Create order items
                $cart = session()->get('cart', []);
                foreach($cart as $id => $item) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $id,
                        'quantity' => $item['quantity'],
                        'price' => $item['price']
                    ]);
                }

                // Clear the cart and shipping address
                session()->forget(['cart', 'shipping_address']);

                return view('checkout.success');
            }

            return redirect()->route('cart.index')->with('error', 'Payment was not successful.');

        } catch (\Exception $e) {
            return redirect()->route('cart.index')->with('error', 'An error occurred while processing your order.');
        }
    }
} 