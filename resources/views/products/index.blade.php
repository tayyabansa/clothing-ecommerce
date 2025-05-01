@extends('layouts.app')

@section('content')
<div class="bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col md:flex-row gap-8">
            <!-- Category Sidebar -->
            <div class="w-full md:w-64 flex-shrink-0">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Categories</h2>
                <div class="space-y-2">
                    <a href="{{ route('products.index') }}" 
                        class="block px-4 py-2 rounded-md {{ !request('category') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-50' }}">
                        All Products
                    </a>
                    @foreach($categories as $category)
                        <a href="{{ route('products.index', ['category' => $category->slug]) }}" 
                            class="block px-4 py-2 rounded-md {{ request('category') == $category->slug ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-50' }}">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Products Grid -->
            <div class="flex-1">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($products as $product)
                        <div class="group relative bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-shadow duration-300">
                            <div class="relative">
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" 
                                    class="w-full h-64 object-cover">
                                @if($product->discount_price)
                                    <div class="absolute top-4 right-4 bg-red-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                                        {{ round((($product->price - $product->discount_price) / $product->price) * 100) }}% OFF
                                    </div>
                                @endif
                            </div>
                            <div class="p-4">
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $product->name }}</h3>
                                <div class="flex items-center justify-between">
                                    <div>
                                        @if($product->discount_price)
                                            <span class="text-red-500 font-bold">${{ number_format($product->discount_price, 2) }}</span>
                                            <span class="text-gray-400 line-through ml-2">${{ number_format($product->price, 2) }}</span>
                                        @else
                                            <span class="text-gray-900 font-bold">${{ number_format($product->price, 2) }}</span>
                                        @endif
                                    </div>
                                    <a href="{{ route('products.show', $product) }}" 
                                        class="text-indigo-600 hover:text-indigo-500">
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

                <div class="mt-8">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 