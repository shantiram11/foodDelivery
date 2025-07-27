<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        return view('dashboard.settings.index');
    }

    public function general()
    {
        return view('dashboard.settings.general');
    }

    public function appearance()
    {
        return view('dashboard.settings.appearance');
    }

    public function email()
    {
        return view('dashboard.settings.email');
    }
}
