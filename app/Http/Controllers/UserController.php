<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->paginate(2);
        Inertia::setRootView('layouts.dashboard');

        return Inertia::render('User/Index', [
            'users' => $users
        ]);
    }
}
