<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index(){
        return view('frontend.home');
    }
    public function checkout()
    {
        return view('frontend.components.sections.proceed-checkout');
    }
    
} 