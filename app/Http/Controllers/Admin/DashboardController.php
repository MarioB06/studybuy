<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index(): View
    {
        $totalUsers = User::count();
        $adminUsers = User::where('bit', true)->count();
        $regularUsers = User::where('bit', false)->count();

        return view('admin.dashboard', compact('totalUsers', 'adminUsers', 'regularUsers'));
    }
}
