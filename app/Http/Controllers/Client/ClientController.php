<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Categorie;
use App\Models\Sale;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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


    /**
     * Creation of the client (Optional/Utility)
     */
    public function createClient()
    {
        $user = Auth::user();

        \FedaPay\FedaPay::setApiKey(config('fedapay.secret_key'));
        \FedaPay\FedaPay::setEnvironment(config('fedapay.environment'));

        \FedaPay\Customer::create([
            "firstname" => $user->firstname,
            "lastname" => $user->lastname,
            "email" => $user->email,
        ]);
    }

    /**
     * Starting escrow / Payment initiation
     */
    public function collecte($productId)
    {
        Log::info("Payment initiation started for product: $productId");
        
        $user = Auth::user();
        $product = Product::findOrFail($productId);
        Log::info("Payment initiation started for product: $product->nom");
        \FedaPay\FedaPay::setApiKey(config('fedapay.secret_key'));
        \FedaPay\FedaPay::setEnvironment(config('fedapay.environment'));

        try {
            Log::info("Creating FedaPay transaction for user: " . $user->email);
            
            $transaction = \FedaPay\Transaction::create([
                'description' => "Achat de : " . $product->nom,
                'amount' => (int) $product->prix,
                'currency' => ['iso' => 'XOF'],
                'callback_url' => route('client.callback'),
                'customer' => [
                    'firstname' => $user->firstname,
                    'lastname' => $user->lastname,
                    'email' => $user->email,
                ],
                // Pass metadata to identify the product and buyer later
                'metadata' => [
                    'product_id' => $product->id,
                    'buyer_id' => $user->id,
                ]
            ]);

            $token = $transaction->generateToken();
            Log::info("Token generated, redirecting to: " . $token->url);
            
            return redirect($token->url);
        } catch (\Exception $e) {
            Log::error("FedaPay Error: " . $e->getMessage());
            return back()->withErrors(['error' => "Erreur lors de l'initialisation du paiement : " . $e->getMessage()]);
        }
    }

    /**
     * FedaPay Callback handler
     */
    public function callback(Request $request)
    {
        $transactionId = $request->input('id');
        $status = $request->input('status');

        Log::info("FedaPay callback received. ID: $transactionId, Status: $status");

        \FedaPay\FedaPay::setApiKey(config('fedapay.secret_key'));
        \FedaPay\FedaPay::setEnvironment(config('fedapay.environment'));

        try {
            $transaction = \FedaPay\Transaction::retrieve($transactionId);
            Log::info("Transaction retrieved. Real status: " . $transaction->status);

            if ($transaction->status === 'approved' || $status === 'approved') {
                $metadata = $transaction->metadata;
                $productId = $metadata['product_id'] ?? null;
                $buyerId = $metadata['buyer_id'] ?? null;

                if ($productId && $buyerId) {
                    $product = Product::find($productId);
                    
                    // Prevent duplicate sales
                    $existingSale = Sale::where('product_id', $productId)
                        ->where('buyer_id', $buyerId)
                        ->where('status', 'completed')
                        ->first();

                    if (!$existingSale) {
                        Sale::create([
                            'product_id' => $product->id,
                            'seller_id' => $product->user_id, // Assuming user_id is the seller
                            'buyer_id' => $buyerId,
                            'amount' => $product->prix,
                            'status' => 'completed',
                        ]);
                        Log::info("Sale recorded successfully.");
                    } else {
                        Log::warning("Sale already exists for this transaction.");
                    }

                    return redirect()->route('client.purchases')->with('success', 'Paiement réussi ! Votre achat a été enregistré.');
                }
            }

            Log::warning("Transaction was not approved.");
            return redirect()->route('explorer')->with('error', 'Le paiement a échoué ou a été annulé.');
        } catch (\Exception $e) {
            Log::error("Callback Verification Error: " . $e->getMessage());
            return redirect()->route('explorer')->with('error', 'Une erreur est survenue lors de la vérification du paiement.');
        }
    }

}
