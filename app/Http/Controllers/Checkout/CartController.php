<?php

namespace App\Http\Controllers\Checkout;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Add item to cart - AJAX endpoint
     */
    public function addToCart(Request $request)
    {
        if ($request->ajax()) {
            $request->validate([
                'menu_id' => 'required|exists:menus,id',
                'quantity' => 'required|integer|min:1'
            ]);

            $menu = Menu::with('restaurant')->findOrFail($request->menu_id);
            $cart = session('cart', []);
            $key = $menu->id;

            if (isset($cart[$key])) {
                $cart[$key]['quantity'] += $request->quantity;
                $cart[$key]['total_price'] = $cart[$key]['quantity'] * $cart[$key]['unit_price'];
            } else {
                $cart[$key] = [
                    'menu_id' => $menu->id,
                    'menu_name' => $menu->name,
                    'unit_price' => $menu->price,
                    'quantity' => $request->quantity,
                    'total_price' => $menu->price * $request->quantity,
                    'restaurant_id' => $menu->restaurant_id,
                    'restaurant_name' => $menu->restaurant->name,
                    'image' => $menu->image
                ];
            }

            session(['cart' => $cart]);

            return response()->json([
                'success' => true,
                'message' => 'Item added to cart!',
                'cart_count' => collect($cart)->sum('quantity'),
                'cart_total' => collect($cart)->sum('total_price')
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Invalid request'], 400);
    }

    /**
     * Update cart quantity - AJAX endpoint
     */
    public function updateQuantity(Request $request)
    {
        if ($request->ajax()) {
            $request->validate([
                'menu_id' => 'required',
                'quantity' => 'required|integer|min:1'
            ]);

            $cart = session('cart', []);
            $key = $request->menu_id;

            if (isset($cart[$key])) {
                $cart[$key]['quantity'] = $request->quantity;
                $cart[$key]['total_price'] = $cart[$key]['quantity'] * $cart[$key]['unit_price'];
                session(['cart' => $cart]);

                return response()->json([
                    'success' => true,
                    'message' => 'Cart updated!',
                    'cart_count' => collect($cart)->sum('quantity'),
                    'cart_total' => collect($cart)->sum('total_price'),
                    'item_total' => $cart[$key]['total_price']
                ]);
            }

            return response()->json(['success' => false, 'message' => 'Item not found'], 404);
        }

        return response()->json(['success' => false, 'message' => 'Invalid request'], 400);
    }

    /**
     * Remove item from cart - AJAX endpoint
     */
    public function removeFromCart(Request $request)
    {
        if ($request->ajax()) {
            $request->validate([
                'menu_id' => 'required'
            ]);

            $cart = session('cart', []);
            $key = $request->menu_id;

            if (isset($cart[$key])) {
                unset($cart[$key]);
                session(['cart' => $cart]);

                return response()->json([
                    'success' => true,
                    'message' => 'Item removed from cart!',
                    'cart_count' => collect($cart)->sum('quantity'),
                    'cart_total' => collect($cart)->sum('total_price'),
                    'cart_empty' => empty($cart)
                ]);
            }

            return response()->json(['success' => false, 'message' => 'Item not found'], 404);
        }

        return response()->json(['success' => false, 'message' => 'Invalid request'], 400);
    }

    /**
     * Clear entire cart - AJAX endpoint
     */
    public function clearCart(Request $request)
    {
        if ($request->ajax()) {
            session()->forget('cart');

            return response()->json([
                'success' => true,
                'message' => 'Cart cleared!',
                'cart_count' => 0,
                'cart_total' => 0,
                'cart_empty' => true
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Invalid request'], 400);
    }

    /**
     * Get cart data - AJAX endpoint
     */
    public function getCartData(Request $request)
    {
        if ($request->ajax()) {
            $cart = session('cart', []);
            $subtotal = collect($cart)->sum('total_price');
            $itemCount = collect($cart)->sum('quantity');

            return response()->json([
                'success' => true,
                'cart_items' => $cart,
                'cart_total' => $subtotal,
                'cart_count' => $itemCount,
                'cart_empty' => empty($cart),
                // Legacy support
                'cart' => $cart,
                'subtotal' => $subtotal,
                'total_amount' => $subtotal,
                'item_count' => $itemCount
            ]);
        }

        // Also handle non-AJAX requests for compatibility
        $cart = session('cart', []);
        $subtotal = collect($cart)->sum('total_price');
        $itemCount = collect($cart)->sum('quantity');

        return response()->json([
            'success' => true,
            'cart_items' => $cart,
            'cart_total' => $subtotal,
            'cart_count' => $itemCount,
            'cart_empty' => empty($cart)
        ]);
    }
}