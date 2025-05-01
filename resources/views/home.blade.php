@extends('layouts.app')

@section('styles')
    <style>
        .hero-gradient {
            background: linear-gradient(135deg, rgba(45, 212, 191, 0.85) 0%, rgba(13, 148, 136, 0.85) 100%),
                url('../assets/images/hero-bg.jpg') center/cover no-repeat !important;
            position: relative !important;
            min-height: 600px;
        }

        .store-name {
            font-family: 'Playfair Display', serif;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
            background: linear-gradient(to right, #ffffff, #e0f2f1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .tagline {
            font-family: 'Poppins', sans-serif;
            letter-spacing: 2px;
        }

        .shop-now-btn {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(5px);
            border: 2px solid rgba(255, 255, 255, 0.2);
        }

        .shop-now-btn:hover {
            background: rgba(255, 255, 255, 1);
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .category-card {
            transition: transform 0.3s ease;
        }

        .category-card:hover {
            transform: translateY(-5px);
        }

        .product-card {
            transition: all 0.3s ease;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .feature-icon {
            transition: transform 0.3s ease;
        }

        .feature-icon:hover {
            transform: scale(1.1);
        }

        .newsletter-bg {
            background: linear-gradient(135deg, #f0fdfa 0%, #ccfbf1 100%);
        }

        .flash-sale-badge {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }

            100% {
                transform: scale(1);
            }
        }
    </style>
@endsection

@section('content')
    <!-- Hero Section -->
    <div class="hero-gradient text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-32">
            <div class="text-center">
                <h1 class="store-name text-5xl md:text-7xl font-extrabold tracking-tight mb-6">
                    ÉLÉGANCE
                </h1>
                <p class="tagline text-xl md:text-2xl mb-8 opacity-90">
                    Where Style Meets Sophistication
                </p>
                <p class="text-lg md:text-xl mb-12 opacity-80 max-w-2xl mx-auto">
                    Discover the perfect blend of contemporary fashion and timeless elegance
                </p>
                <a href="{{ route('products.index') }}"
                    class="shop-now-btn inline-block text-teal-600 px-10 py-4 rounded-full font-semibold 
                transition duration-300">
                    Explore Collection
                </a>
            </div>
        </div>
    </div>

    <!-- Categories Section -->
    <div class="bg-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-gray-900 text-center mb-12">Shop by Category</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @php
                    $categories = DB::table('categories')->get();
                @endphp
              @foreach ($categories as $category)
              <a href="{{ route('products.index', ['category' => strtolower($category->name)]) }}"
                  class="category-card bg-gray-50 rounded-xl p-6 text-center hover:bg-gray-100">
                  <div class="w-16 h-16 mx-auto mb-4 bg-teal-100 rounded-full flex items-center justify-center">
                      <svg class="w-8 h-8 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                      </svg>
                  </div>
                  <h3 class="text-lg font-semibold text-gray-900">{{ $category->name }}</h3> <!-- Display category name -->
              </a>
          @endforeach
          
            </div>
        </div>
    </div>

    <!-- Featured Products -->
    <div class="bg-gray-50 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900">Featured Products</h2>
                <a href="{{ route('products.index') }}" class="text-teal-600 hover:text-teal-500 font-semibold">
                    View All →
                </a>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                @foreach ($featuredProducts as $product)
                    <div class="product-card bg-white rounded-xl overflow-hidden">
                        <div class="relative">
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                                class="w-full h-64 object-cover">
                            @if ($product->discount_price)
                                <div
                                    class="absolute top-4 right-4 bg-red-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                                    {{ round((($product->price - $product->discount_price) / $product->price) * 100) }}% OFF
                                </div>
                            @endif
                        </div>
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $product->name }}</h3>
                            <div class="flex items-center justify-between">
                                <div>
                                    @if ($product->discount_price)
                                        <span
                                            class="text-red-500 font-bold">${{ number_format($product->discount_price, 2) }}</span>
                                        <span
                                            class="text-gray-400 line-through ml-2">${{ number_format($product->price, 2) }}</span>
                                    @else
                                        <span
                                            class="text-gray-900 font-bold">${{ number_format($product->price, 2) }}</span>
                                    @endif
                                </div>
                                <a href="{{ route('products.show', $product) }}" class="text-teal-600 hover:text-teal-500">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Flash Sale Section -->
    <div class="bg-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-gradient-to-r from-teal-500 to-emerald-500 rounded-2xl p-8 text-white">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h2 class="text-3xl font-bold mb-2">Flash Sale</h2>
                        <p class="text-lg opacity-90">Limited time offers on selected items</p>
                    </div>
                    <div class="flash-sale-badge bg-white text-teal-500 px-4 py-2 rounded-full font-bold">
                        Ends in: 24:00:00
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    @foreach ($flashSaleProducts as $product)
                        <div class="product-card bg-white rounded-xl overflow-hidden">
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                                class="w-full h-48 object-cover">
                            <div class="p-4">
                                <h3 class="text-gray-900 font-semibold mb-2">{{ $product->name }}</h3>
                                <div class="flex items-center justify-between">
                                    <div>
                                        <span
                                            class="text-red-500 font-bold">${{ number_format($product->discount_price, 2) }}</span>
                                        <span
                                            class="text-gray-400 line-through ml-2">${{ number_format($product->price, 2) }}</span>
                                    </div>
                                    <a href="{{ route('products.show', $product) }}"
                                        class="bg-teal-500 text-white px-4 py-2 rounded-full text-sm font-semibold hover:bg-teal-600">
                                        Shop Now
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="bg-gray-50 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="text-center">
                    <div
                        class="feature-icon w-16 h-16 mx-auto mb-4 bg-teal-100 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Free Shipping</h3>
                    <p class="text-gray-600">On orders over $50</p>
                </div>
                <div class="text-center">
                    <div
                        class="feature-icon w-16 h-16 mx-auto mb-4 bg-teal-100 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Secure Payment</h3>
                    <p class="text-gray-600">100% secure checkout</p>
                </div>
                <div class="text-center">
                    <div
                        class="feature-icon w-16 h-16 mx-auto mb-4 bg-teal-100 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Easy Returns</h3>
                    <p class="text-gray-600">30 days return policy</p>
                </div>
                <div class="text-center">
                    <div
                        class="feature-icon w-16 h-16 mx-auto mb-4 bg-teal-100 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">24/7 Support</h3>
                    <p class="text-gray-600">Dedicated support team</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Newsletter Section -->
    <div class="newsletter-bg py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl mx-auto text-center">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Stay Updated</h2>
                <p class="text-lg text-gray-600 mb-8">Subscribe to our newsletter for the latest updates and offers</p>
                <form class="flex flex-col sm:flex-row gap-4 max-w-xl mx-auto">
                    <input type="email" placeholder="Enter your email"
                        class="flex-1 px-6 py-3 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-teal-500">
                    <button type="submit"
                        class="bg-teal-600 text-white px-8 py-3 rounded-full font-semibold hover:bg-teal-700 
                    transition duration-300">
                        Subscribe
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
