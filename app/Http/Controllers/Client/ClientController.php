<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Categorie;
use App\Models\Sale;
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
}
