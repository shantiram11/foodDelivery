<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        return view('dashboard.orders.index');
    }

    public function pending(Request $request)
    {
        return view('dashboard.orders.pending');
    }

    public function declined(Request $request)
    {
        return view('dashboard.orders.declined');
    }

    public function completed(Request $request)
    {
        return view('dashboard.orders.completed');
    }
}
