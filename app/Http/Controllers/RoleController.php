<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class RoleController extends Controller
{
    public function index()
    {
        return Inertia::render('Role/Index');
    }
}
