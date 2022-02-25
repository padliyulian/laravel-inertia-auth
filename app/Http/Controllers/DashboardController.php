<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        Inertia::setRootView('layouts.dashboard');
        return Inertia::render('Dashboard');
    }
}
