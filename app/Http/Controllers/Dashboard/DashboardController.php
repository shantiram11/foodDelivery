<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Menu;
use App\Models\Order;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(){
        $user = auth()->user();

        // Get restaurant-specific data
        $stats = [
            'total_users' => $this->getTotalUsers($user),
            'total_menus' => $this->getTotalMenus($user),
            'total_orders' => $this->getTotalOrders($user),
            'total_restaurants' => $this->getTotalRestaurants($user),
            'recent_orders' => $this->getRecentOrders($user),
        ];

        // Get chart data
        $chartData = [
            'orderTrend' => $this->getOrderTrendData($user),
            'orderStatus' => $this->getOrderStatusData($user),
        ];

        return view('dashboard.dashboard', compact('stats', 'chartData'));
    }

    private function getTotalUsers($user)
    {
        if ($user->isAdmin()) {
            return User::count();
        }

        if ($user->isRestaurantUser()) {
            return User::where('restaurant_id', $user->restaurant_id)->count();
        }

        return 0;
    }

    private function getTotalMenus($user)
    {
        if ($user->isAdmin()) {
            return Menu::count();
        }

        if ($user->isRestaurantUser()) {
            return Menu::where('restaurant_id', $user->restaurant_id)->count();
        }

        return 0;
    }

    private function getTotalOrders($user)
    {
        if ($user->isAdmin()) {
            return Order::count();
        }

        if ($user->isRestaurantUser()) {
            return Order::where('restaurant_id', $user->restaurant_id)->count();
        }

        return 0;
    }

    private function getTotalRestaurants($user)
    {
        if ($user->isAdmin()) {
            return Restaurant::count();
        }

        // Restaurant users can only see their own restaurant
        return 1;
    }

    private function getRecentOrders($user)
    {
        if ($user->isAdmin()) {
            return Order::with(['user', 'restaurant'])
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();
        }

        if ($user->isRestaurantUser()) {
            return Order::with(['user', 'restaurant'])
                ->where('restaurant_id', $user->restaurant_id)
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();
        }

        return collect();
    }

    private function getOrderTrendData($user)
    {
        $endDate = Carbon::now();
        $startDate = Carbon::now()->subDays(13); // Last 14 days for better trend visualization

        $query = Order::whereBetween('created_at', [$startDate, $endDate]);

        if ($user->isRestaurantUser() || $user->isDeliveryStaff()) {
            $query->where('restaurant_id', $user->restaurant_id);
        }

        $orders = $query->get();

        // Group by date
        $orderTrend = [];
        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            $dayOrders = $orders->filter(function($order) use ($date) {
                return $order->created_at->format('Y-m-d') === $date->format('Y-m-d');
            });

            // Group by status for this day
            $statusCounts = $dayOrders->groupBy('status')->map(function($orders) {
                return $orders->count();
            });

            $orderTrend[$date->format('M d')] = [
                'total_orders' => $dayOrders->count(),
                'completed' => $statusCounts['completed'] ?? 0,
                'pending' => $statusCounts['pending'] ?? 0,
                'confirmed' => $statusCounts['confirmed'] ?? 0,
                'preparing' => $statusCounts['preparing'] ?? 0,
                'cancelled' => $statusCounts['cancelled'] ?? 0,
            ];
        }

        return $orderTrend;
    }

    private function getOrderStatusData($user)
    {
        $query = Order::query();

        if ($user->isRestaurantUser() || $user->isDeliveryStaff()) {
            $query->where('restaurant_id', $user->restaurant_id);
        }

        $orders = $query->get();

        $statusData = $orders->groupBy('status')->map(function($orders, $status) {
            return [
                'status' => $status,
                'count' => $orders->count(),
                'percentage' => 0 // Will be calculated in view
            ];
        });

        // Calculate percentages
        $total = $orders->count();
        if ($total > 0) {
            $statusData = $statusData->map(function($data) use ($total) {
                $data['percentage'] = round(($data['count'] / $total) * 100, 1);
                return $data;
            });
        }

        return $statusData;
    }


}
