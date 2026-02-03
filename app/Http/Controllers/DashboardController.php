<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Client;
use App\Models\Products;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $today = date('Y-m-d');
        
        // Today's Money (Total Sales Today)
        $todaysMoney = Sale::whereDate('tgl_jual', $today)->sum('total_bayar');
        
        // Today's Transactions (Count of Sales Today)
        $todaysTransactions = Sale::whereDate('tgl_jual', $today)->count();
        
        // Total Clients
        $totalClients = Client::count();
        
        // Total Sales (Lifetime)
        $totalSales = Sale::sum('total_bayar');

        // Recent Orders (Limit 5)
        $recentOrders = Order::with('pelanggan')->latest('tgl_pemesanan')->take(5)->get();

        return view('dashboard.index', [
            'title' => 'Dashboard',
            'todaysMoney' => $todaysMoney,
            'todaysTransactions' => $todaysTransactions,
            'totalClients' => $totalClients,
            'totalSales' => $totalSales,
            'recentOrders' => $recentOrders
        ]);
    }
}
