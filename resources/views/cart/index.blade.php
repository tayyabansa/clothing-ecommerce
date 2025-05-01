@extends('layouts.app')

@section('styles')
    <style>
        .cart-title {
            font-family: 'Playfair Display', serif;
        }

        .cart-item {
            transition: all 0.3s ease;
        }

        .cart-item:hover {
            background: #f0fdfa;
        }

        .remove-btn {
            transition: all 0.3s ease;
        }

        .remove-btn:hover {
            transform: translateY(-2px);
        }

        .checkout-btn {
            background: linear-gradient(to right, #2dd4bf, #0d9488);
            transition: all 0.3s ease;
        }

        .checkout-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(45, 212, 191, 0.3);
        }

        .continue-shopping-btn {
            background: linear-gradient(to right, #2dd4bf, #0d9488);
            transition: all 0.3s ease;
        }

        .continue-shopping-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(45, 212, 191, 0.3);
        }

        .product-link {
            font-family: 'Playfair Display', serif;
            transition: all 0.3s ease;
        }

        .product-link:hover {
            color: #0d9488;
        }

        .summary-card {
            background: linear-gradient(to bottom right, #ffffff, #f0fdfa);
            border: 1px solid #e2e8f0;
        }

        .quantity-btn {
            background: #f0fdfa;
            color: #0d9488;
            transition: all 0.3s ease;
        }

        .quantity-btn:hover {
            background: #0d9488;
            color: white;
        }

        .quantity-input {
            width: 60px;
            text-align: center;
            border: 1px solid #e2e8f0;
            border-radius: 0.5rem;
            padding: 0.5rem;
            font-size: 1rem;
            color: #1f2937;
        }

        .quantity-input:focus {
            outline: none;
            border-color: #0d9488;
            box-shadow: 0 0 0 2px rgba(13, 148, 136, 0.1);
        }
    </style>
@endsection

@section('content')
    <div class="bg-gray-50">
        <div class="max-w-2xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:max-w-7xl lg:px-8">
            <h1 class="cart-title text-4xl font-bold text-gray-900 text-center mb-12">Shopping Cart</h1>


            @if (count($cart) > 0)
                <div class="mt-12 lg:grid lg:grid-cols-12 lg:gap-x-12 lg:items-start">
                    <div class="lg:col-span-7">
                        <ul class="border border-gray-200 rounded-xl divide-y divide-gray-200 overflow-hidden">
                            @foreach ($cart as $id => $item)
                                <li class="cart-item flex py-6 sm:py-10 px-6">
                                    <div class="flex-shrink-0">
                                        <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}"
                                            class="w-24 h-24 rounded-xl object-center object-cover sm:w-32 sm:h-32 hover:scale-105 transition-transform duration-300">
                                    </div>

                                    <div class="ml-4 flex-1 flex flex-col sm:ml-6">
                                        <div>
                                            <div class="flex justify-between">
                                                <h4 class="text-lg">
                                                    <a href="#"
                                                        class="product-link font-medium text-gray-900">{{ $item['name'] }}</a>
                                                </h4>
                                                <p class="ml-4 text-lg font-semibold text-teal-600 item-total">
                                                    ${{ number_format($item['price'] * $item['quantity'], 2) }}</p>
                                            </div>

                                            <!-- Quantity Controls -->
                                            <div class="mt-4 flex items-center">

                                                <input type="number" class="quantity-input" value="{{ $item['quantity'] }}"
                                                    min="1" data-id="{{ $id }}"
                                                    data-price="{{ $item['price'] }}">

                                            </div>
                                        </div>

                                        <div class="mt-4 flex-1 flex items-end justify-between">
                                            <form action="{{ route('cart.remove', ['product' => $id]) }}" method="POST"
                                                class="flex">
                                                @method('DELETE')

                                                @csrf

                                                <button type="submit"
                                                    class="remove-btn inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-red-600 bg-red-50 hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
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
                        <div class="summary-card rounded-xl px-6 py-8">
                            <h2 class="text-2xl font-semibold text-gray-900 mb-6"
                                style="font-family: 'Playfair Display', serif;">Order Summary</h2>
                            <div class="space-y-4">
                                <div class="flex items-center justify-between">
                                    <p class="text-lg text-gray-600">Subtotal</p>
                                    <p class="text-lg font-semibold text-gray-900 cart-subtotal">
                                        ${{ number_format($total, 2) }}</p>
                                </div>
                                <div class="flex items-center justify-between border-t border-gray-200 pt-4">
                                    <p class="text-xl font-semibold text-gray-900">Order Total</p>
                                    <p class="text-xl font-semibold text-teal-600 cart-total">
                                        ${{ number_format($total, 2) }}</p>
                                </div>
                            </div>
                            <div class="mt-8">
                                {{-- <form action="{{ route('checkout.store') }}" method="POST">
                                @csrf
                                <button type="submit" class="checkout-btn w-full inline-flex items-center justify-center px-8 py-4 border border-transparent text-lg font-medium rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                    </svg>
                                    Proceed to Checkout
                                </button>
                            </form> --}}
                                <a href="{{ route('checkout.index') }}"
                                    class="checkout-btn w-full inline-flex items-center justify-center px-8 py-4 border border-transparent text-lg font-medium rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                    </svg>
                                    Proceed to Checkout
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="mt-12 text-center">
                    <svg class="mx-auto h-24 w-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    <h2 class="mt-4 text-2xl font-semibold text-gray-900" style="font-family: 'Playfair Display', serif;">
                        Your Cart is Empty</h2>
                    <p class="mt-2 text-gray-600 mb-8">Looks like you haven't added any items to your cart yet.</p>
                    <a href="{{ route('products.index') }}"
                        class="continue-shopping-btn inline-flex items-center px-8 py-4 border border-transparent text-lg font-medium rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        Continue Shopping
                    </a>
                </div>
            @endif
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const quantityInputs = document.querySelectorAll('.quantity-input');
            const decreaseBtns = document.querySelectorAll('.decrease-btn');
            const increaseBtns = document.querySelectorAll('.increase-btn');

            function updateQuantity(id, quantity) {
                fetch(`/cart/update/${id}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            quantity: quantity
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Update item total
                            const itemTotal = document.querySelector(`.item-total[data-id="${id}"]`);
                            if (itemTotal) {
                                itemTotal.textContent = `$${data.itemTotal}`;
                            }

                            // Update cart totals
                            document.querySelector('.cart-subtotal').textContent = `$${data.cartTotal}`;
                            document.querySelector('.cart-total').textContent = `$${data.cartTotal}`;
                        }
                    });
            }

            quantityInputs.forEach(input => {
                input.addEventListener('change', function() {
                    const id = this.dataset.id;
                    const quantity = parseInt(this.value);
                    if (quantity > 0) {
                        updateQuantity(id, quantity);
                    } else {
                        this.value = 1;
                        updateQuantity(id, 1);
                    }
                });
            });

            decreaseBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const id = this.dataset.id;
                    const input = document.querySelector(`.quantity-input[data-id="${id}"]`);
                    const currentValue = parseInt(input.value);
                    if (currentValue > 1) {
                        input.value = currentValue - 1;
                        updateQuantity(id, currentValue - 1);
                    }
                });
            });

            increaseBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const id = this.dataset.id;
                    const input = document.querySelector(`.quantity-input[data-id="${id}"]`);
                    const currentValue = parseInt(input.value);
                    input.value = currentValue + 1;
                    updateQuantity(id, currentValue + 1);
                });
            });
        });
    </script>
@endsection
