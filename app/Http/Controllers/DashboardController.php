<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Item;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function stats()
    {
        $totalOrders = Order::count();
        $totalRevenue = Order::sum('total_price');
        $totalItems = Item::count();
        $totalUsers = User::count();

        return response()->json([
            'status' => 'success',
            'data' => [
                'total_orders' => $totalOrders,
                'total_revenue' => $totalRevenue,
                'total_items' => $totalItems,
                'total_users' => $totalUsers
            ]
        ]);
    }
}
