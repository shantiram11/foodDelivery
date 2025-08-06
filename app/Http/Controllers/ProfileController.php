<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        // Get user's orders with related data
        $orders = Order::with(['restaurant', 'orderItems.menu', 'deliveryStaff'])
            ->where('user_id', $request->user()->id)
            ->orderBy('created_at', 'desc')
            ->paginate(3);

        return view('profile', [
            'user' => $request->user(),
            'orders' => $orders,
        ]);
    }

    /**
     * Cancel an order (only if status is 'confirmed')
     */
    public function cancelOrder(Request $request, $orderId): RedirectResponse
    {
        $order = Order::where('id', $orderId)
            ->where('user_id', $request->user()->id)
            ->where('status', 'confirmed')
            ->first();

        if (!$order) {
            return Redirect::route('profile.edit')->with('error', 'Order not found or cannot be cancelled.');
        }

        $order->status = 'cancelled';
        $order->save();

        return Redirect::route('profile.edit')->with('success', 'Order cancelled successfully.');
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
