<?php

namespace App\Http\Controllers\Creator;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SalesController extends Controller
{
    public function index()
    {
        $sales = Sale::where('seller_id', Auth::id())
            ->with(['product', 'buyer'])
            ->latest()
            ->paginate(10);

        return view('Creator.sales', compact('sales'));
    }
}
