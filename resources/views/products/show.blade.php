@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Product Image -->
                    <div class="aspect-w-1 aspect-h-1 w-full overflow-hidden rounded-lg bg-gray-200">
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="h-full w-full object-cover object-center">
                    </div>

                    <!-- Product Info -->
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">{{ $product->name }}</h1>
                        <p class="mt-2 text-sm text-gray-500">{{ $product->category->name }}</p>
                        
                        <!-- Rating -->
                        <div class="mt-4 flex items-center">
                            <div class="flex items-center">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="h-5 w-5 {{ $i <= 4 ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endfor
                            </div>
                            <p class="ml-2 text-sm text-gray-500">4.0 (120 reviews)</p>
                        </div>

                        <!-- Price -->
                        <div class="mt-4">
                            <p class="text-3xl font-bold text-gray-900">${{ number_format($product->price, 2) }}</p>
                        </div>

                        <!-- Description -->
                        <div class="mt-6">
                            <h3 class="text-lg font-medium text-gray-900">Description</h3>
                            <p class="mt-2 text-gray-600">{{ $product->description }}</p>
                        </div>

                        <!-- Highlights -->
                        <div class="mt-6">
                            <h3 class="text-lg font-medium text-gray-900">Highlights</h3>
                            <ul class="mt-2 list-disc list-inside text-gray-600">
                                <li>Premium quality material</li>
                                <li>Comfortable fit</li>
                                <li>Durable and long-lasting</li>
                                <li>Easy to maintain</li>
                            </ul>
                        </div>

                        <!-- Add to Cart -->
                        <div class="mt-8">
                            <form action="{{ route('cart.add', $product) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    Add to Cart
                                </button>
                            </form>
                        </div>

                        <!-- Policies -->
                        <div class="mt-8 border-t border-gray-200 pt-8">
                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <div>
                                    <h3 class="text-sm font-medium text-gray-900">Free Shipping</h3>
                                    <p class="mt-2 text-sm text-gray-500">Get free shipping on all orders over $50</p>
                                </div>
                                <div>
                                    <h3 class="text-sm font-medium text-gray-900">Easy Returns</h3>
                                    <p class="mt-2 text-sm text-gray-500">30-day return policy for all items</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 