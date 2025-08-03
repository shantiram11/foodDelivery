<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Menu;
use App\Models\Order;
use App\Models\Restaurant;
use Illuminate\Http\Request;

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

        return view('dashboard.dashboard', compact('stats'));
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
}
