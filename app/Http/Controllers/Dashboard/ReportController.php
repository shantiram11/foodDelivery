<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        return view('dashboard.reports.index');
    }

    public function sales()
    {
        return view('dashboard.reports.sales');
    }

    public function orders()
    {
        return view('dashboard.reports.order');
    }

    public function revenue()
    {
        return view('dashboard.reports.revenue');
    }

}
