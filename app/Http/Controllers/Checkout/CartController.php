<?php

namespace App\Http\Controllers\Checkout;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $menu = Menu::with('restaurant')->findOrFail($request->menu_id);
        $cart = session('cart', []);

        // Check if cart already has items from different restaurant
        if (!empty($cart)) {
            $firstItem = reset($cart);
            if ($firstItem['restaurant_id'] != $menu->restaurant_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'You can only order from one restaurant at a time. Please clear your cart first.'
                ]);
            }
        }

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
            'message' => 'Item added to cart!'
        ]);
    }

    public function updateQuantity(Request $request)
    {
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
        }

        return redirect()->back()->with('success', 'Cart updated!');
    }

    public function removeFromCart(Request $request)
    {
        $request->validate([
            'menu_id' => 'required'
        ]);

        $cart = session('cart', []);
        $key = $request->menu_id;

        if (isset($cart[$key])) {
            unset($cart[$key]);
            session(['cart' => $cart]);
        }

        return redirect()->back()->with('success', 'Item removed from cart!');
    }

    public function clearCart()
    {
        session()->forget('cart');
        return redirect()->back()->with('success', 'Cart cleared!');
    }

    public function getCartData()
    {
        $cart = session('cart', []);
        $subtotal = collect($cart)->sum('total_price');
        $itemCount = collect($cart)->sum('quantity');

        return [
            'cart' => $cart,
            'subtotal' => $subtotal,
            'total_amount' => $subtotal,
            'item_count' => $itemCount
        ];
    }
}