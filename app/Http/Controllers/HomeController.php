<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        // Get featured products (products with highest ratings or most popular)
        $featuredProducts = Product::where('is_featured', true)
            ->orWhere('rating', '>=', 4)
            ->take(8)
            ->get();

        // Get flash sale products (products with discounts)
        $flashSaleProducts = Product::whereNotNull('discount_price')
            ->where('discount_price', '<', DB::raw('price'))
            ->orderBy('discount_price', 'asc')
            ->take(4)
            ->get();

        return view('home', compact('featuredProducts', 'flashSaleProducts'));
    }
} 