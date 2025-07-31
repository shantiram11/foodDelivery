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
    public function index()
    {
        $cart = session('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('menu')->with('error', 'Your cart is empty!');
        }

        $cartController = new CartController();
        $cartData = $cartController->getCartData();
        
        return view('frontend.components.sections.proceed-checkout', $cartData);
    }

    public function store(Request $request)
    {
        // No validation needed for simple checkout

        $cart = session('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('menu')->with('error', 'Your cart is empty!');
        }

        try {
            DB::beginTransaction();

            // Get restaurant ID from cart items
            $restaurantId = reset($cart)['restaurant_id'];
            
            // Calculate totals
            $subtotal = collect($cart)->sum('total_price');
            $totalAmount = $subtotal; // No delivery fee for takeaway

            // Create order
            $order = Order::create([
                'user_id' => Auth::id(),
                'restaurant_id' => $restaurantId,
                'order_number' => Order::generateOrderNumber(),
                'status' => 'pending',
                'payment_method' => 'cod',
                'payment_status' => 'pending',
                'subtotal' => $subtotal,
                'total_amount' => $totalAmount,
                'customer_phone' => auth()->user()->phone ?? '000-000-0000'
            ]);

            // Create order items
            foreach ($cart as $item) {
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

            // Clear cart
            session()->forget('cart');

            DB::commit();

            return redirect()->route('order.confirmation', $order->id)
                           ->with('success', 'Order placed successfully!');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Failed to place order. Please try again.');
        }
    }

    public function confirmation($orderId)
    {
        $order = Order::with(['orderItems', 'restaurant', 'user'])->findOrFail($orderId);
        
        // Ensure user can only see their own orders
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }

        return view('frontend.components.sections.order-confirmation', compact('order'));
    }
}