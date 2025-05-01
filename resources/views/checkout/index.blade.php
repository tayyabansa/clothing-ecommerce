@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-gray-50 to-gray-100 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-12">
                <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight">Checkout</h1>
                <p class="mt-2 text-lg text-gray-600">Complete your purchase</p>
            </div>

            <div class="bg-white shadow-xl rounded-2xl overflow-hidden">
                <!-- Order Summary Section -->
                <div class="p-8 border-b border-gray-200 bg-gradient-to-r from-indigo-50 to-blue-50">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Order Summary</h2>
                    <div class="space-y-6">
                        @foreach($cart as $id => $item)
                            <div class="flex items-center space-x-6 bg-white p-4 rounded-lg shadow-sm">
                                <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" 
                                    class="w-24 h-24 object-cover rounded-lg shadow-md">
                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold text-gray-900">{{ $item['name'] }}</h3>
                                    <p class="text-sm text-gray-500 mt-1">Quantity: {{ $item['quantity'] }}</p>
                                    <p class="text-lg font-bold text-indigo-600 mt-2">
                                        ${{ number_format($item['price'] * $item['quantity'], 2) }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Shipping Form Section -->
                <div class="p-8">
                    <form action="{{ route('checkout.store') }}" method="POST" class="space-y-8">
                        @csrf
                        
                        <!-- Shipping Information -->
                        <div class="space-y-6">
                            <div class="flex items-center space-x-3">
                                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <h3 class="text-2xl font-bold text-gray-900">Shipping Information</h3>
                            </div>
                            
                            <div class="bg-gray-50 p-6 rounded-xl">
                                <label for="shipping_address" class="block text-sm font-medium text-gray-700 mb-2">
                                    Delivery Address
                                </label>
                                <textarea id="shipping_address" name="shipping_address" rows="3" required 
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base"
                                    placeholder="Enter your complete shipping address"></textarea>
                            </div>
                        </div>

                        <!-- Order Total -->
                        <div class="bg-gray-50 rounded-xl p-6">
                            <div class="flex justify-between items-center">
                                <span class="text-xl font-semibold text-gray-900">Total Amount</span>
                                <span class="text-3xl font-bold text-indigo-600">${{ number_format($total, 2) }}</span>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" 
                            class="w-full bg-gradient-to-r from-indigo-600 to-blue-600 text-white py-4 px-6 rounded-xl 
                            hover:from-indigo-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 
                            focus:ring-indigo-500 transition-all duration-200 transform hover:scale-[1.02] 
                            flex items-center justify-center space-x-3 text-lg font-semibold shadow-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                            </svg>
                            <span>Pay ${{ number_format($total, 2) }}</span>
                        </button>

                        <!-- Security Notice -->
                        <div class="text-center text-sm text-gray-500 mt-4">
                            <div class="flex items-center justify-center space-x-2">
                                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                                <span>Secure payment powered by Stripe</span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 