<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard with platform metrics.
     */
    public function dashboard()
    {
        $stats = [
            'totalUsers' => User::count(),
            'totalProducts' => Product::count(),
            'totalSales' => Sale::count(),
            'totalRevenue' => Sale::sum('amount'),
            'creatorsCount' => User::where('role', 'createur')->count(),
            'clientsCount' => User::where('role', 'client')->count(),
        ];

        // Data for diagrams (example: sales over the last 7 days)
        $salesData = Sale::selectRaw('DATE(created_at) as date, SUM(amount) as total')
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->take(7)
            ->get();

        return view('Admin.dashboard', compact('stats', 'salesData'));
    }

    /**
     * List and manage users.
     */
    public function users()
    {
        $users = User::latest()->paginate(20);
        return view('Admin.users', compact('users'));
    }

    /**
     * List and manage products.
     */
    public function products()
    {
        $products = Product::with('categorie', 'user')->latest()->paginate(20);
        return view('Admin.products', compact('products'));
    }
}
