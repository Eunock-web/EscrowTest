<?php

namespace App\Http\Controllers\Creator;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        
        $totalRevenue = Sale::where('seller_id', $userId)->sum('amount');
        $totalSales = Sale::where('seller_id', $userId)->count();
        $totalProducts = Product::where('user_id', $userId)->count();
        
        // Mock data for views (0 for now as we don't have a tracking table)
        $totalViews = 0; 

        // Monthly sales for chart (PostgreSQL version)
        $monthlySales = Sale::where('seller_id', $userId)
            ->select(DB::raw('COUNT(*) as count'), DB::raw("TO_CHAR(created_at, 'Month') as month"))
            ->groupBy('month')
            ->get();

        return view('Creator.analytics', compact('totalRevenue', 'totalSales', 'totalProducts', 'totalViews', 'monthlySales'));
    }
}
