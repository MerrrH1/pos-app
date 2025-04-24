<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $role = Auth::user()->role;
        
        return match ($role) {
            'sales_admin' => view('dashboard.sales'),
            'purchases_admin' => view('dashboard.purchases'),
            'super_admin' => view('dashboard.super'),
            default => abort(403, "Unauthorized")
        };
    }
}
