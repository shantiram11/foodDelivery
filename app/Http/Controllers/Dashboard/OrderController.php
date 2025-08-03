<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = $this->getFilteredOrders();
        return view('dashboard.orders.index', compact('orders'));
    }

    public function pending(Request $request)
    {
        $orders = $this->getFilteredOrders(['confirmed', 'preparing']);
        return view('dashboard.orders.pending', compact('orders'));
    }

    public function declined(Request $request)
    {
        $orders = $this->getFilteredOrders(['cancelled']);
        return view('dashboard.orders.declined', compact('orders'));
    }

    public function completed(Request $request)
    {
        $orders = $this->getFilteredOrders(['completed']);
        return view('dashboard.orders.completed', compact('orders'));
    }

    private function getFilteredOrders($statuses = null)
    {
        $query = Order::with(['user', 'restaurant', 'orderItems.menu']);

        $currentUser = auth()->user();

        // Apply restaurant filtering for restaurant users
        if ($currentUser->isRestaurantUser()) {
            $query->where('restaurant_id', $currentUser->restaurant_id);
        }

        // Filter by status if provided
        if ($statuses) {
            $query->whereIn('status', $statuses);
        }

        return $query->orderBy('created_at', 'desc')->paginate(15);
    }
}
