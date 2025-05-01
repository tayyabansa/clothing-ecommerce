@extends('layouts.app')

@section('styles')
<style>
    .product-title {
        font-family: 'Playfair Display', serif;
    }
    .product-description {
        font-family: 'Poppins', sans-serif;
    }
    .add-to-cart-btn {
        background: linear-gradient(to right, #2dd4bf, #0d9488);
        transition: all 0.3s ease;
    }
    .add-to-cart-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(45, 212, 191, 0.3);
    }
    .policy-card {
        transition: all 0.3s ease;
    }
    .policy-card:hover {
        transform: translateY(-2px);
        background: #f0fdfa;
    }
    .rating-star {
        color: #fbbf24;
    }
    .highlight-item {
        position: relative;
        padding-left: 1.5rem;
    }
    .highlight-item::before {
        content: "•";
        color: #0d9488;
        position: absolute;
        left: 0;
        font-size: 1.5rem;
    }
</style>
@endsection

@section('content')
<div class="bg-gray-50 py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl">
            <div class="p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                    <!-- Product Image -->
                    <div class="aspect-w-1 aspect-h-1 w-full overflow-hidden rounded-xl bg-gray-100">
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" 
                            class="h-full w-full object-cover object-center hover:scale-105 transition-transform duration-500">
                    </div>

                    <!-- Product Info -->
                    <div class="product-description">
                        <h1 class="product-title text-4xl font-bold text-gray-900 mb-2">{{ $product->name }}</h1>
                        <p class="text-sm text-teal-600 font-medium">{{ $product->category->name }}</p>
                        
                        <!-- Rating -->
                        <div class="mt-6 flex items-center">
                            <div class="flex items-center">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="h-6 w-6 {{ $i <= 4 ? 'rating-star' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endfor
                            </div>
                            <p class="ml-3 text-sm text-gray-600">4.0 (120 reviews)</p>
                        </div>

                        <!-- Price -->
                        <div class="mt-6">
                            @if($product->discount_price)
                                <div class="flex items-center">
                                    <p class="text-3xl font-bold text-teal-600">${{ number_format($product->discount_price, 2) }}</p>
                                    <p class="ml-3 text-xl text-gray-400 line-through">${{ number_format($product->price, 2) }}</p>
                                </div>
                            @else
                                <p class="text-3xl font-bold text-gray-900">${{ number_format($product->price, 2) }}</p>
                            @endif
                        </div>

                        <!-- Description -->
                        <div class="mt-8">
                            <h3 class="text-xl font-semibold text-gray-900 mb-4">Description</h3>
                            <p class="text-gray-600 leading-relaxed">{{ $product->description }}</p>
                        </div>

                        <!-- Highlights -->
                        <div class="mt-8">
                            <h3 class="text-xl font-semibold text-gray-900 mb-4">Highlights</h3>
                            <ul class="space-y-3">
                                <li class="highlight-item text-gray-600">Premium quality material</li>
                                <li class="highlight-item text-gray-600">Comfortable fit</li>
                                <li class="highlight-item text-gray-600">Durable and long-lasting</li>
                                <li class="highlight-item text-gray-600">Easy to maintain</li>
                            </ul>
                        </div>

                        <!-- Add to Cart -->
                        <div class="mt-8">
                            <form action="{{ route('cart.add', $product) }}" method="POST">
                                @csrf
                                <button type="submit" class="add-to-cart-btn w-full inline-flex items-center justify-center px-8 py-4 border border-transparent text-base font-medium rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    Add to Cart
                                </button>
                            </form>
                        </div>

                        <!-- Policies -->
                        <div class="mt-12 border-t border-gray-200 pt-8">
                            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                                <div class="policy-card p-4 rounded-xl">
                                    <h3 class="text-lg font-semibold text-gray-900">Free Shipping</h3>
                                    <p class="mt-2 text-gray-600">Get free shipping on all orders over $50</p>
                                </div>
                                <div class="policy-card p-4 rounded-xl">
                                    <h3 class="text-lg font-semibold text-gray-900">Easy Returns</h3>
                                    <p class="mt-2 text-gray-600">30-day return policy for all items</p>
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