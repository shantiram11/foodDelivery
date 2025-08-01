<?php

namespace App\Http\Controllers\Checkout;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    /**
     * Show checkout page
     */
    public function index()
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('home')->with('error', 'Your cart is empty!');
        }

                // Get cart data for view
        $subtotal = collect($cart)->sum('total_price');
        $itemCount = collect($cart)->sum('quantity');

        return view('frontend.components.sections.proceed-checkout', [
            'cart' => $cart,
            'subtotal' => $subtotal,
            'total_amount' => $subtotal,
            'item_count' => $itemCount
        ]);
    }

    /**
     * Process checkout - handles both AJAX and regular form submissions
     */
    public function store(Request $request)
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Your cart is empty!'
                ], 400);
            }
            return redirect()->route('home')->with('error', 'Your cart is empty!');
        }

        try {
            DB::beginTransaction();

            // Group cart items by restaurant
            $itemsByRestaurant = collect($cart)->groupBy('restaurant_id');
            $orderIds = [];

            // Create separate orders for each restaurant
            foreach ($itemsByRestaurant as $restaurantId => $restaurantItems) {
                $restaurantTotal = $restaurantItems->sum('total_price');

                // Create order for this restaurant
                $order = Order::create([
                    'user_id' => Auth::id(),
                    'restaurant_id' => $restaurantId,
                    'order_number' => Order::generateOrderNumber(),
                    'status' => 'pending',
                    'payment_method' => $request->input('payment_method', 'cod'),
                    'payment_status' => 'pending',
                    'subtotal' => $restaurantTotal,
                    'total_amount' => $restaurantTotal,
                    'customer_phone' => auth()->user()->phone ?? '000-000-0000'
                ]);

                $orderIds[] = $order->id;

                // Create order items for this restaurant
                foreach ($restaurantItems as $item) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'menu_id' => $item['menu_id'],
                        'menu_name' => $item['menu_name'],
                        'unit_price' => $item['unit_price'],
                        'quantity' => $item['quantity'],
                        'total_price' => $item['total_price'],
                        'restaurant_id' => $item['restaurant_id']
                    ]);
                }
            }

            // Clear cart
            session()->forget('cart');
            DB::commit();

            // Store order IDs for confirmation
            session(['recent_order_ids' => $orderIds]);

            $successMessage = count($orderIds) === 1 ? 'Order placed successfully!' : 'Orders placed successfully!';

            // Handle AJAX response
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => $successMessage,
                    'order_count' => count($orderIds),
                    'redirect_url' => route('order.confirmation')
                ]);
            }

            // Handle regular form submission
            return redirect()->route('order.confirmation')->with('success', $successMessage);

        } catch (\Exception $e) {
            DB::rollback();

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to place order. Please try again.'
                ], 500);
            }

            return redirect()->back()->with('error', 'Failed to place order. Please try again.');
        }
    }

    /**
     * Show order confirmation
     */
    public function confirmationUnified($orderId = null)
    {
        // Direct order ID access
        if ($orderId) {
            $order = Order::with(['orderItems', 'restaurant', 'user'])->findOrFail($orderId);

            if ($order->user_id !== Auth::id()) {
                abort(403, 'Unauthorized access');
            }

            return view('frontend.components.sections.order-confirmation', compact('order'));
        }

        // Recent orders from checkout
        $orderIds = session('recent_order_ids', []);

        if (empty($orderIds)) {
            return redirect()->route('home')->with('error', 'No recent orders found!');
        }

        session()->forget('recent_order_ids');

        $orders = Order::with(['orderItems', 'restaurant', 'user'])
                      ->whereIn('id', $orderIds)
                      ->where('user_id', Auth::id())
                      ->get();

        if ($orders->isEmpty()) {
            return redirect()->route('home')->with('error', 'Orders not found!');
        }

        if ($orders->count() === 1) {
            $order = $orders->first();
            return view('frontend.components.sections.order-confirmation', compact('order'));
        } else {
            return view('frontend.components.sections.order-confirmation', compact('orders'));
        }
    }
}