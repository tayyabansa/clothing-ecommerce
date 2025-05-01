<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'ÉLÉGANCE') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800;900&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            .logo-text {
                font-family: 'Playfair Display', serif;
                background: linear-gradient(to right, #2dd4bf, #0d9488);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                font-weight: 700;
                letter-spacing: 1px;
            }
            .nav-link {
                font-family: 'Poppins', sans-serif;
                font-weight: 500;
            }
            .nav-link.active {
                color: #0d9488;
                border-color: #0d9488;
            }
            .nav-link:hover {
                color: #0d9488;
                border-color: #0d9488;
            }
        </style>
        
        @yield('styles')
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            <nav class="bg-white border-b border-gray-100">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="shrink-0 flex items-center">
                                <a href="{{ route('products.index') }}" class="text-3xl logo-text">
                                    ÉLÉGANCE
                                </a>
                            </div>

                            <!-- Navigation Links -->
                            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                                <a href="{{ route('products.index') }}" class="nav-link inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('products.index') ? 'active' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} text-sm font-medium leading-5 transition duration-150 ease-in-out focus:outline-none">
                                    {{ __('Home') }}
                                </a>
                                <a href="{{ route('products.index') }}" class="nav-link inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('products.index') ? 'active' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} text-sm font-medium leading-5 transition duration-150 ease-in-out focus:outline-none">
                                    {{ __('Products') }}
                                </a>
                            </div>
                        </div>

                        <div class="hidden sm:flex sm:items-center sm:ml-6">
                            <!-- Cart Link -->
                            <a href="{{ route('cart.index') }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 hover:text-teal-600 focus:outline-none transition duration-150 ease-in-out">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                @if(session()->has('cart') && count(session('cart')) > 0)
                                    <span class="absolute -top-1 -right-1 bg-teal-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">
                                        {{ count(session('cart')) }}
                                    </span>
                                @endif
                            </a>
                        </div>

                        <!-- Hamburger -->
                        <div class="-mr-2 flex items-center sm:hidden">
                            <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-teal-600 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                    <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
                    <div class="pt-2 pb-3 space-y-1">
                        <a href="{{ route('products.index') }}" class="nav-link block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('products.index') ? 'active border-teal-400 text-teal-700 bg-teal-50' : 'border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300' }} text-base font-medium transition duration-150 ease-in-out focus:outline-none focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300">
                            {{ __('Home') }}
                        </a>
                        <a href="{{ route('products.index') }}" class="nav-link block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('products.index') ? 'active border-teal-400 text-teal-700 bg-teal-50' : 'border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300' }} text-base font-medium transition duration-150 ease-in-out focus:outline-none focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300">
                            {{ __('Products') }}
                        </a>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                @yield('content')
            </main>
        </div>

        <!-- Alpine.js -->
        <script src="//unpkg.com/alpinejs" defer></script>
    </body>
</html>
