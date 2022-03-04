<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->data['currentMenu1'] = 'dashboard';
        $this->data['currentMenu2'] = '';
        $this->data['currentMenu3'] = '';
    }

    public function index()
    {
        Inertia::setRootView('layouts.dashboard');
        return Inertia::render('Dashboard', $this->data);
    }
}
