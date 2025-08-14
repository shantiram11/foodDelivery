<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{


    public function index(Request $request)
    {
        $currentUser = auth()->user();

        // Date range filtering
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth());
        $endDate = $request->get('end_date', Carbon::now()->endOfMonth());

        // Build base query with restaurant filtering
        $query = Order::with(['restaurant', 'user', 'orderItems'])
            ->whereBetween('created_at', [$startDate, $endDate]);

        if ($currentUser->isRestaurantUser() || $currentUser->isDeliveryStaff()) {
            $query->where('restaurant_id', $currentUser->restaurant_id);
        }

        // Get sales data
        $orders = $query->get();

        // Calculate metrics
        $totalOrders = $orders->count();
        $totalRevenue = $orders->sum('total_amount');
        $averageOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;
        $completedOrders = $orders->where('status', 'completed')->count();
        $completionRate = $totalOrders > 0 ? ($completedOrders / $totalOrders) * 100 : 0;

        // Top performing restaurants
        $restaurantData = $orders->groupBy('restaurant_id')
            ->map(function ($restaurantOrders) {
                $restaurant = $restaurantOrders->first()->restaurant;
                return [
                    'id' => $restaurant->id,
                    'name' => $restaurant->name,
                    'total_orders' => $restaurantOrders->count(),
                    'total_revenue' => $restaurantOrders->sum('total_amount'),
                    'avg_order_value' => $restaurantOrders->avg('total_amount')
                ];
            })
            ->sortByDesc('total_revenue')
            ->take(5)
            ->values();

        // Calculate performance percentage based on highest revenue
        $maxRevenue = $restaurantData->max('total_revenue') ?: 1;
        $topRestaurants = $restaurantData->map(function ($restaurant) use ($maxRevenue) {
            $restaurant['performance_percentage'] = $maxRevenue > 0 ? ($restaurant['total_revenue'] / $maxRevenue) * 100 : 0;
            return $restaurant;
        });

        // Daily sales for chart
        $dailySales = $orders->groupBy(function($order) {
                return $order->created_at->format('Y-m-d');
            })
            ->map(function ($dayOrders) {
                return [
                    'total_orders' => $dayOrders->count(),
                    'total_revenue' => $dayOrders->sum('total_amount')
                ];
            });

        // Monthly comparison
        $currentMonth = $orders->whereBetween('created_at', [
            Carbon::now()->startOfMonth(),
            Carbon::now()->endOfMonth()
        ]);
        $lastMonth = Order::whereBetween('created_at', [
            Carbon::now()->subMonth()->startOfMonth(),
            Carbon::now()->subMonth()->endOfMonth()
        ]);

        if ($currentUser->isRestaurantUser() || $currentUser->isDeliveryStaff()) {
            $lastMonth->where('restaurant_id', $currentUser->restaurant_id);
        }

        $lastMonthRevenue = $lastMonth->sum('total_amount');
        $revenueGrowth = $lastMonthRevenue > 0 ?
            (($currentMonth->sum('total_amount') - $lastMonthRevenue) / $lastMonthRevenue) * 100 : 0;

        // Order status distribution
        $totalOrdersCount = $orders->count();
        $statusDistribution = $orders->groupBy('status')
            ->map(function ($statusOrders) use ($totalOrdersCount) {
                $statusCount = $statusOrders->count();
                return [
                    'count' => $statusCount,
                    'percentage' => $totalOrdersCount > 0 ? ($statusCount / $totalOrdersCount) * 100 : 0
                ];
            });

        // Get all restaurants for filter (admin only)
        $restaurants = $currentUser->isAdmin() ? Restaurant::all() : collect();

        if ($request->ajax()) {
            return response()->json([
                'totalOrders' => $totalOrders,
                'totalRevenue' => $totalRevenue,
                'averageOrderValue' => $averageOrderValue,
                'completionRate' => round($completionRate, 2),
                'revenueGrowth' => round($revenueGrowth, 2),
                'topRestaurants' => $topRestaurants,
                'dailySales' => $dailySales,
                'statusDistribution' => $statusDistribution
            ]);
        }

        return view('dashboard.reports.index', compact(
            'totalOrders', 'totalRevenue', 'averageOrderValue', 'completionRate',
            'revenueGrowth', 'topRestaurants', 'dailySales', 'statusDistribution',
            'restaurants', 'startDate', 'endDate'
        ));
    }

    /**
     * Get sales data for AJAX requests
     */
    public function sales(Request $request)
    {
        return $this->index($request);
    }

    /**
     * Get revenue data for charts
     */
    public function revenue(Request $request)
    {
        $currentUser = auth()->user();

        // Get 12 months of revenue data
        $revenueData = collect();

        for ($i = 11; $i >= 0; $i--) {
            $monthStart = Carbon::now()->subMonths($i)->startOfMonth();
            $monthEnd = Carbon::now()->subMonths($i)->endOfMonth();

            // Consider revenue from orders that are at least confirmed or completed
            // This avoids showing all zeros when no orders have been marked completed yet
            $query = Order::whereBetween('created_at', [$monthStart, $monthEnd])
                ->whereIn('status', ['confirmed', 'completed']);

            if ($currentUser->isRestaurantUser() || $currentUser->isDeliveryStaff()) {
                $query->where('restaurant_id', $currentUser->restaurant_id);
            }

            $monthRevenue = $query->sum('total_amount');

            $revenueData->push([
                'month' => $monthStart->format('Y-m'),
                'revenue' => $monthRevenue ?: 0
            ]);
        }

        if ($request->has('chart_data')) {
            return response()->json($revenueData);
        }

        return response()->json($revenueData);
    }
}
