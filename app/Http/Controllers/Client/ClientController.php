<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Categorie;
use App\Models\Sale;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    /**
     * Display the product explorer.
     */
    public function index(Request $request)
    {
        $query = Product::with('categorie');

        if ($request->has('search')) {
            $query->where('nom', 'like', '%' . $request->search . '%');
        }

        if ($request->has('category') && $request->category != 'all') {
            $query->where('categorie_id', $request->category);
        }

        $products = $query->latest()->paginate(12);
        $categories = Categorie::all();

        return view('Products.explorer', compact('products', 'categories'));
    }

    /**
     * Display a specific product details.
     */
    public function show($id)
    {
        $product = Product::with('categorie')->findOrFail($id);
        return view('Products.details', compact('product'));
    }

    /**
     * Display user's purchases.
     */
    public function purchases()
    {
        $purchases = Auth::user()->purchases()->with('product', 'seller')->latest()->get();
        return view('Client.purchases', compact('purchases'));
    }

    /**
     * Display the list of creators.
     */
    public function creators(Request $request)
    {
        $query = User::where('role', 'createur');

        if ($request->has('search')) {
            $query->where('pseudo', 'like', '%' . $request->search . '%');
        }

        if ($request->has('specialite') && $request->specialite != 'all') {
            $query->where('specialite', $request->specialite);
        }

        $creators = $query->withCount('products')->latest()->paginate(12);
        
        // stats for the banner
        $totalCreators = User::where('role', 'createur')->count();
        $totalProducts = Product::count();
        $totalSalesCount = Sale::count();
        $totalRevenue = Sale::sum('amount');

        return view('Products.createurs', compact('creators', 'totalCreators', 'totalProducts', 'totalSalesCount', 'totalRevenue'));
    }
}
