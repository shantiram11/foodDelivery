<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Models\Menu;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index(){
        $restaurants = Restaurant::where('status', 'active')->get();
        $menus = Menu::with('restaurant')->whereHas('restaurant', function($query) {
            $query->where('status', 'active');
        })->get();
        return view('frontend.home', compact('restaurants', 'menus'));

    }
    public function checkout()
    {
        return view('frontend.components.sections.proceed-checkout');
    }
    
} 