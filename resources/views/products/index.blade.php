@extends('layouts.app')

@section('styles')
<style>
    .category-link {
        font-family: 'Poppins', sans-serif;
        transition: all 0.3s ease;
    }
    .category-link.active {
        background: linear-gradient(to right, #2dd4bf, #0d9488);
        color: white;
    }
    .category-link:hover:not(.active) {
        background: #f0fdfa;
        color: #0d9488;
    }
    .product-card {
        font-family: 'Poppins', sans-serif;
        transition: all 0.3s ease;
    }
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    .product-title {
        font-family: 'Playfair Display', serif;
    }
    .discount-badge {
        background: linear-gradient(to right, #2dd4bf, #0d9488);
    }
    .view-icon {
        color: #0d9488;
        transition: all 0.3s ease;
    }
    .view-icon:hover {
        transform: translateX(5px);
    }
    .pagination-link {
        color: #0d9488;
    }
    .pagination-link:hover {
        background: #f0fdfa;
    }
</style>
@endsection

@section('content')
<div class="bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Page Title -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4" style="font-family: 'Playfair Display', serif;">
                Our Collection
            </h1>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Discover our curated selection of premium fashion pieces
            </p>
        </div>

        <div class="flex flex-col md:flex-row gap-8">
            <!-- Category Sidebar -->
            <div class="w-full md:w-64 flex-shrink-0">
                <h2 class="text-xl font-semibold text-gray-900 mb-6" style="font-family: 'Playfair Display', serif;">Categories</h2>
                <div class="space-y-2">
                    <a href="{{ route('products.index') }}" 
                        class="category-link block px-4 py-3 rounded-lg {{ !request('category') ? 'active' : 'text-gray-700' }}">
                        All Products
                    </a>
                    @foreach($categories as $category)
                        <a href="{{ route('products.index', ['category' => $category->slug]) }}" 
                            class="category-link block px-4 py-3 rounded-lg {{ request('category') == $category->slug ? 'active' : 'text-gray-700' }}">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Products Grid -->
            <div class="flex-1">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                    @foreach($products as $product)
                        <div class="product-card bg-white rounded-xl overflow-hidden">
                            <div class="relative">
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" 
                                    class="w-full h-72 object-cover">
                                @if($product->discount_price)
                                    <div class="absolute top-4 right-4 discount-badge text-white px-4 py-2 rounded-full text-sm font-semibold">
                                        {{ round((($product->price - $product->discount_price) / $product->price) * 100) }}% OFF
                                    </div>
                                @endif
                            </div>
                            <div class="p-6">
                                <h3 class="product-title text-xl font-semibold text-gray-900 mb-3">{{ $product->name }}</h3>
                                <div class="flex items-center justify-between">
                                    <div>
                                        @if($product->discount_price)
                                            <span class="text-teal-600 font-bold text-lg">${{ number_format($product->discount_price, 2) }}</span>
                                            <span class="text-gray-400 line-through ml-2">${{ number_format($product->price, 2) }}</span>
                                        @else
                                            <span class="text-gray-900 font-bold text-lg">${{ number_format($product->price, 2) }}</span>
                                        @endif
                                    </div>
                                    <a href="{{ route('products.show', $product) }}" 
                                        class="view-icon">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-12">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 