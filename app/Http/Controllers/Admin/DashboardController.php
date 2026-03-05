<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Burger;
use App\Models\Payment;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Orders currently in progress (waiting or being prepared)
        $ordersInProgress = Order::whereIn('status', ['En attente', 'En preparation'])->count();

        // Orders validated (paid) today
        $ordersCompletedToday = Order::whereDate('created_at', today())
            ->where('status', Order::STATUS_PAID)
            ->count();

        // Revenue today
        $dailyRevenue = Payment::whereDate('created_at', today())->sum('amount');

        // Total burgers in the system
        $totalOrders = Burger::count();

        // Last 5 orders with items
        $latestOrders = Order::with('items')->latest()->take(5)->get();

        // Orders per month (12 months of the current year)
        $ordersPerMonth = array_fill(0, 12, 0);
        $monthly = Order::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->pluck('total', 'month');

        foreach ($monthly as $month => $total) {
            $ordersPerMonth[$month - 1] = $total;
        }

        // Top 5 burgers sold this month (provide French keys expected by blade)
        $topProducts = OrderItem::selectRaw('burger_name as nom, SUM(quantity) as total')
            ->whereMonth('created_at', now()->month)
            ->groupBy('burger_name')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'ordersInProgress',
            'ordersCompletedToday',
            'dailyRevenue',
            'totalOrders',
            'latestOrders',
            'ordersPerMonth',
            'topProducts'
        ));
    }
}