@extends('layouts.app')

@section('content')
<div class="bg-white">
    <div class="max-w-2xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:max-w-7xl lg:px-8">
        <h1 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">Shopping Cart</h1>

        @if(count($cart) > 0)
            <div class="mt-12 lg:grid lg:grid-cols-12 lg:gap-x-12 lg:items-start">
                <div class="lg:col-span-7">
                    <ul class="border-t border-b border-gray-200 divide-y divide-gray-200">
                        @foreach($cart as $id => $item)
                            <li class="flex py-6 sm:py-10">
                                <div class="flex-shrink-0">
                                    <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="w-24 h-24 rounded-md object-center object-cover sm:w-32 sm:h-32">
                                </div>

                                <div class="ml-4 flex-1 flex flex-col sm:ml-6">
                                    <div>
                                        <div class="flex justify-between">
                                            <h4 class="text-sm">
                                                <a href="#" class="font-medium text-gray-700 hover:text-gray-800">{{ $item['name'] }}</a>
                                            </h4>
                                            <p class="ml-4 text-sm font-medium text-gray-900">${{ number_format($item['price'], 2) }}</p>
                                        </div>
                                        <p class="mt-1 text-sm text-gray-500">Quantity: {{ $item['quantity'] }}</p>
                                    </div>

                                    <div class="mt-4 flex-1 flex items-end justify-between">
                                        <form action="{{ route('cart.remove', ['product' => $id]) }}" method="POST" class="flex">
                                            @csrf
                                            <button type="submit" class="inline-flex items-center px-3 py-1.5 border border-transparent text-sm font-medium rounded-md text-red-700 bg-red-100 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-150 ease-in-out">
                                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                                Remove
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="mt-16 lg:mt-0 lg:col-span-5">
                    <div class="bg-gray-50 rounded-lg px-4 py-6 sm:p-6 lg:p-8">
                        <h2 class="text-lg font-medium text-gray-900">Order summary</h2>
                        <div class="mt-6 space-y-4">
                            <div class="flex items-center justify-between">
                                <p class="text-sm text-gray-600">Subtotal</p>
                                <p class="text-sm font-medium text-gray-900">${{ number_format($total, 2) }}</p>
                            </div>
                            <div class="flex items-center justify-between border-t border-gray-200 pt-4">
                                <p class="text-base font-medium text-gray-900">Order total</p>
                                <p class="text-base font-medium text-gray-900">${{ number_format($total, 2) }}</p>
                            </div>
                        </div>
                        <div class="mt-6">
                            <form action="{{ route('checkout.store') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                    </svg>
                                    Proceed to Checkout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="mt-12 text-center">
                <p class="text-gray-500 mb-4">Your cart is empty</p>
                <a href="{{ route('products.index') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    Continue Shopping
                </a>
            </div>
        @endif
    </div>
</div>
@endsection 