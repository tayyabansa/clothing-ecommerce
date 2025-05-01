<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Get total sales
        $totalSales = Order::where('status', 'completed')
            ->sum('total_amount');

        // Calculate sales growth
        $currentMonthSales = Order::where('status', 'completed')
            ->whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))
            ->sum('total_amount');

        $lastMonthSales = Order::where('status', 'completed')
            ->whereMonth('created_at', date('m', strtotime('-1 month')))
            ->whereYear('created_at', date('Y', strtotime('-1 month')))
            ->sum('total_amount');

        $salesGrowth = $lastMonthSales > 0 
            ? (($currentMonthSales - $lastMonthSales) / $lastMonthSales) * 100 
            : 0;

        // Get total orders
        $totalOrders = Order::count();

        // Calculate orders growth
        $currentMonthOrders = Order::whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))
            ->count();

        $lastMonthOrders = Order::whereMonth('created_at', date('m', strtotime('-1 month')))
            ->whereYear('created_at', date('Y', strtotime('-1 month')))
            ->count();

        $ordersGrowth = $lastMonthOrders > 0 
            ? (($currentMonthOrders - $lastMonthOrders) / $lastMonthOrders) * 100 
            : 0;

        // Get total products
        $totalProducts = Product::count();

        // Calculate products growth
        $currentMonthProducts = Product::whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))
            ->count();

        $lastMonthProducts = Product::whereMonth('created_at', date('m', strtotime('-1 month')))
            ->whereYear('created_at', date('Y', strtotime('-1 month')))
            ->count();

        $productsGrowth = $lastMonthProducts > 0 
            ? (($currentMonthProducts - $lastMonthProducts) / $lastMonthProducts) * 100 
            : 0;

        // Get recent orders
        $recentOrders = Order::with('user')
            ->latest()
            ->take(5)
            ->get();

        // Get top selling products
        $topProducts = Product::select('products.*', DB::raw('SUM(order_items.quantity) as total_sold'))
            ->join('order_items', 'products.id', '=', 'order_items.product_id')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->where('orders.status', 'completed')
            ->groupBy('products.id')
            ->orderBy('total_sold', 'desc')
            ->take(5)
            ->get();

        // Get monthly sales data for the chart
        $monthlySales = Order::where('status', 'completed')
            ->whereYear('created_at', date('Y'))
            ->select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(total_amount) as total')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('total', 'month')
            ->toArray();

        // Fill in missing months with 0
        $monthlySalesData = array_fill(1, 12, 0);
        foreach ($monthlySales as $month => $total) {
            $monthlySalesData[$month] = $total;
        }

        return view('admin.dashboard', compact(
            'totalSales',
            'totalOrders',
            'totalProducts',
            'recentOrders',
            'topProducts',
            'monthlySalesData',
            'salesGrowth',
            'ordersGrowth',
            'productsGrowth'
        ));
    }
} 