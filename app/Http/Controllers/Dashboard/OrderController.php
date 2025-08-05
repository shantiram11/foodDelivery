<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Http\Constants\UserRoleConstant;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->getOrdersDataTable($request);
        }
        return view('dashboard.orders.index');
    }

    public function pending(Request $request)
    {
        if ($request->ajax()) {
            return $this->getOrdersDataTable($request, ['confirmed', 'preparing']);
        }
        return view('dashboard.orders.pending');
    }

    public function declined(Request $request)
    {
        if ($request->ajax()) {
            return $this->getOrdersDataTable($request, ['cancelled']);
        }
        return view('dashboard.orders.declined');
    }

    public function completed(Request $request)
    {
        if ($request->ajax()) {
            return $this->getOrdersDataTable($request, ['completed']);
        }
        return view('dashboard.orders.completed');
    }

        public function show($id)
    {
        $order = Order::with(['user', 'restaurant', 'orderItems.menu', 'deliveryStaff'])->findOrFail($id);

        // Check access permissions
        $currentUser = auth()->user();
        if ($currentUser->isRestaurantUser() && $order->restaurant_id !== $currentUser->restaurant_id) {
            abort(403, 'Access denied.');
        }

        // Delivery staff can only view orders assigned to them or from their restaurant
        if ($currentUser->isDeliveryStaff()) {
            if ($order->delivery_staff_id !== $currentUser->id && $order->restaurant_id !== $currentUser->restaurant_id) {
                abort(403, 'Access denied.');
            }
        }

        // Get available delivery staff for this restaurant
        $deliveryStaff = User::where('role', UserRoleConstant::DELIVERY_STAFF)
            ->where('restaurant_id', $order->restaurant_id)
            ->get();

        return view('dashboard.orders.show', compact('order', 'deliveryStaff'));
    }

        public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:confirmed,preparing,completed,cancelled'
        ]);

        $order = Order::findOrFail($id);

        // Check update permissions
        $currentUser = auth()->user();
        if ($currentUser->isRestaurantUser() && $order->restaurant_id !== $currentUser->restaurant_id) {
            return response()->json(['success' => false, 'message' => 'Access denied.'], 403);
        }

        // Delivery staff can only update orders assigned to them
        if ($currentUser->isDeliveryStaff() && $order->delivery_staff_id !== $currentUser->id) {
            return response()->json(['success' => false, 'message' => 'You can only update orders assigned to you.'], 403);
        }

        $order->status = $request->status;
        $order->save();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Order status updated successfully!',
                'status' => $order->status
            ]);
        }

        return redirect()->back()->with('success', 'Order status updated successfully!');
    }

    public function assignDeliveryStaff(Request $request, $id)
    {
        $request->validate([
            'delivery_staff_id' => 'required|exists:users,id'
        ]);

        $order = Order::findOrFail($id);

        // Check assignment permissions - only restaurant users and admins can assign delivery staff
        $currentUser = auth()->user();
        if ($currentUser->isDeliveryStaff()) {
            return response()->json(['success' => false, 'message' => 'You do not have permission to assign delivery staff.'], 403);
        }

        if ($currentUser->isRestaurantUser() && $order->restaurant_id !== $currentUser->restaurant_id) {
            return response()->json(['success' => false, 'message' => 'Access denied.'], 403);
        }

        // Verify the delivery staff belongs to the same restaurant
        $deliveryStaff = User::where('id', $request->delivery_staff_id)
            ->where('role', UserRoleConstant::DELIVERY_STAFF)
            ->where('restaurant_id', $order->restaurant_id)
            ->first();

        if (!$deliveryStaff) {
            return response()->json(['success' => false, 'message' => 'Invalid delivery staff selected.'], 400);
        }

        $order->delivery_staff_id = $request->delivery_staff_id;
        $order->save();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Delivery staff assigned successfully!',
                'staff_name' => $deliveryStaff->name
            ]);
        }

        return redirect()->back()->with('success', 'Delivery staff assigned successfully!');
    }

    private function getOrdersDataTable(Request $request, $statuses = null)
    {
        $query = Order::with(['user', 'restaurant', 'orderItems.menu', 'deliveryStaff']);

        $currentUser = auth()->user();

        // Apply restaurant filtering for restaurant users
        if ($currentUser->isRestaurantUser()) {
            $query->where('restaurant_id', $currentUser->restaurant_id);
        }

        // Delivery staff can only see orders assigned to them or from their restaurant
        if ($currentUser->isDeliveryStaff()) {
            $query->where(function($q) use ($currentUser) {
                $q->where('delivery_staff_id', $currentUser->id)
                  ->orWhere('restaurant_id', $currentUser->restaurant_id);
            });
        }

        // Filter by status if provided
        if ($statuses) {
            $query->whereIn('status', $statuses);
        }

        if ($search = $request->input('search.value')) {
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                    ->orWhereHas('user', function($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%")
                                  ->orWhere('email', 'like', "%{$search}%");
                    })
                    ->orWhereHas('restaurant', function($restQuery) use ($search) {
                        $restQuery->where('name', 'like', "%{$search}%");
                    })
                    ->orWhere('customer_phone', 'like', "%{$search}%");
            });
        }

        $total = $query->count();

        $orders = $query->orderBy('created_at', 'desc')
            ->skip($request->input('start'))
            ->take($request->input('length'))
            ->get();

        $data = $orders->map(function ($order) {
            $statusBadge = $this->getStatusBadge($order->status);

            $actions = '
                <a href="'.route('orders.show', $order->id).'" class="btn btn-sm btn-primary" title="View Details">
                    <i class="bi bi-eye-fill"></i>
                </a>';

            // Add status update buttons for non-completed/cancelled orders
            if (!in_array($order->status, ['completed', 'cancelled'])) {
                if ($order->status === 'confirmed') {
                    $actions .= '
                    <button class="btn btn-sm btn-warning update-status" data-id="'.$order->id.'" data-status="preparing" title="Mark as Preparing">
                        <i class="bi bi-clock-fill"></i>
                    </button>
                    <button class="btn btn-sm btn-success update-status" data-id="'.$order->id.'" data-status="completed" title="Mark as Completed">
                        <i class="bi bi-check-circle-fill"></i>
                    </button>';
                } elseif ($order->status === 'preparing') {
                    $actions .= '
                    <button class="btn btn-sm btn-success update-status" data-id="'.$order->id.'" data-status="completed" title="Mark as Completed">
                        <i class="bi bi-check-circle-fill"></i>
                    </button>';
                }

                $actions .= '
                <button class="btn btn-sm btn-danger update-status" data-id="'.$order->id.'" data-status="cancelled" title="Cancel Order">
                    <i class="bi bi-x-circle-fill"></i>
                </button>';
            }

            return [
                'id' => $order->id,
                'order_number' => $order->order_number,
                'customer' => $order->user ? $order->user->name : 'Guest',
                'restaurant' => $order->restaurant ? $order->restaurant->name : 'N/A',
                'items_count' => $order->orderItems->count(),
                'total_amount' => '$' . number_format($order->total_amount, 2),
                'delivery_staff' => $order->deliveryStaff ? $order->deliveryStaff->name : '<span class="text-muted">Not Assigned</span>',
                'status' => $statusBadge,
                'created_at' => $order->created_at->format('M d, Y H:i'),
                'action' => $actions
            ];
        });

        return response()->json([
            'draw' => $request->input('draw'),
            'recordsTotal' => $total,
            'recordsFiltered' => $total,
            'data' => $data,
        ]);
    }

    private function getStatusBadge($status)
    {
        switch ($status) {
            case 'confirmed':
                return '<span class="badge bg-info">Confirmed</span>';
            case 'preparing':
                return '<span class="badge bg-warning">Preparing</span>';
            case 'completed':
                return '<span class="badge bg-success">Completed</span>';
            case 'cancelled':
                return '<span class="badge bg-danger">Cancelled</span>';
            default:
                return '<span class="badge bg-secondary">Unknown</span>';
        }
    }
}
