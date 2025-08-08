<?php

namespace App\Http\Controllers\Checkout;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Services\EsewaService;

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
                    'status' => 'confirmed',
                    'payment_method' => $request->input('payment_method', 'cod'),
                    'payment_status' => 'pending',
                    'subtotal' => $restaurantTotal,
                    'total_amount' => $restaurantTotal,
                    'customer_phone' => $request->input('customer_phone', auth()->user()->phone ?? '9841234567')
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

            $paymentMethod = $request->input('payment_method', 'cod');

            if ($paymentMethod === 'esewa') {
                // For eSewa, do NOT clear the cart yet; proceed to redirect
                DB::commit();

                // For simplicity with split-orders: eSewa expects single amount.
                // Here we take total of all restaurant orders and attach a shared transaction UUID on each.
                $totalAmount = Order::whereIn('id', $orderIds)->sum('total_amount');
                $transactionUuid = 'TXN-' . now()->format('YmdHis') . '-' . uniqid();

                // Save the transaction UUID on all created orders
                Order::whereIn('id', $orderIds)->update(['esewa_transaction_uuid' => $transactionUuid]);

                $service = new EsewaService();
                $productCode = config('services.esewa.product_code');
                $successUrl = route('payment.esewa.success');
                $failureUrl = route('payment.esewa.failure');

                $fields = [
                    'amount' => number_format($totalAmount, 2, '.', ''),
                    'tax_amount' => number_format(0, 2, '.', ''),
                    'total_amount' => number_format($totalAmount, 2, '.', ''),
                    'transaction_uuid' => $transactionUuid,
                    'product_code' => $productCode,
                    'product_service_charge' => number_format(0, 2, '.', ''),
                    'product_delivery_charge' => number_format(0, 2, '.', ''),
                    'success_url' => $successUrl,
                    'failure_url' => $failureUrl,
                ];

                $signature = $service->generateSignature($fields);
                $fields['signature'] = $signature;
                $fields['signed_field_names'] = implode(',', $service->getSignedFieldsList());

                // Persist pending order ids for later reconciliation if needed
                session(['pending_esewa_order_ids' => $orderIds]);

                // Show auto-posting form view
                return view('frontend.components.sections.esewa-redirect', [
                    'formUrl' => config('services.esewa.form_url'),
                    'payload' => $fields,
                ]);
            }

            // COD and other immediate methods
            // Clear cart after successful order creation
            session()->forget('cart');
            DB::commit();

            session(['recent_order_ids' => $orderIds]);

            $successMessage = count($orderIds) === 1 ? 'Order placed successfully!' : 'Orders placed successfully!';

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => $successMessage,
                    'order_count' => count($orderIds),
                    'redirect_url' => route('order.confirmation')
                ]);
            }

            return redirect()->route('order.confirmation')->with('success', $successMessage);

        } catch (\Exception $e) {
            DB::rollback();

            // Log the error
            \Log::error('Checkout failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => Auth::id()
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to place order: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()->with('error', 'Failed to place order: ' . $e->getMessage());
        }
    }

    public function esewaSuccess(Request $request)
    {
        // eSewa returns at least: amount, total_amount, transaction_uuid, product_code, reference_id, status, signed_field_names, signature
        $data = $request->all();

        $service = new EsewaService();
        $signedFields = [];
        if (!empty($data['signed_field_names'])) {
            $signedFields = array_filter(array_map('trim', explode(',', $data['signed_field_names'])));
        } else {
            $signedFields = $service->getSignedFieldsList();
        }

        $fieldsToVerify = [];
        foreach ($signedFields as $name) {
            $fieldsToVerify[$name] = $data[$name] ?? '';
        }

        $signatureProvided = $data['signature'] ?? '';
        $isValid = $signatureProvided && $service->verifySignature($fieldsToVerify, $signatureProvided);

        if (!$isValid) {
            return redirect()->route('payment.esewa.failure')->with('error', 'Invalid payment signature.');
        }

        $transactionUuid = $data['transaction_uuid'] ?? null;
        $referenceId = $data['reference_id'] ?? null;

        if (!$transactionUuid) {
            return redirect()->route('home')->with('error', 'Missing transaction reference.');
        }

        // Mark all orders with this UUID as paid
        $orders = Order::where('esewa_transaction_uuid', $transactionUuid)->get();
        if ($orders->isEmpty()) {
            return redirect()->route('home')->with('error', 'Related orders not found.');
        }

        foreach ($orders as $order) {
            $order->payment_status = 'paid';
            $order->status = $order->status === 'confirmed' ? 'confirmed' : $order->status; // keep current flow
            $order->esewa_reference_id = $referenceId;
            $order->esewa_paid_at = now();
            $order->save();
        }

        // Clear cart after success
        session()->forget('cart');
        session()->forget('pending_esewa_order_ids');

        session(['recent_order_ids' => $orders->pluck('id')->all()]);

        return redirect()->route('order.confirmation')->with('success', 'Payment successful. Order placed!');
    }

    public function esewaFailure(Request $request)
    {
        // Optionally read transaction_uuid to cancel pending orders
        $transactionUuid = $request->input('transaction_uuid');
        if ($transactionUuid) {
            Order::where('esewa_transaction_uuid', $transactionUuid)
                ->where('payment_status', 'pending')
                ->update(['status' => 'cancelled']);
        }

        // Keep cart for retry
        return redirect()->route('checkout')->with('error', 'Payment failed or cancelled. Please try again.');
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