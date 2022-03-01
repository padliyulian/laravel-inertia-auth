<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function getLogin()
    {
        Inertia::setRootView('layouts.auth');
        return Inertia::render('Auth/Login');
    }
}
