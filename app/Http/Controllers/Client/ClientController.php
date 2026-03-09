<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use App\Models\PaymentLog;
use App\Models\Product;
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
            'firstname' => $user->firstname,
            'lastname' => $user->lastname,
            'email' => $user->email,
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
            Log::info('Creating FedaPay transaction for user: ' . $user->email);

            $transaction = \FedaPay\Transaction::create([
                'description' => 'Achat de : ' . $product->nom,
                'amount' => (int) $product->prix,
                'currency' => ['iso' => 'XOF'],
                'callback_url' => route('client.callback'),
                'customer' => [
                    'firstname' => $user->firstname,
                    'lastname' => $user->lastname,
                    'email' => $user->email,
                ],
                // Pass custom_metadata to identify the product and buyer later
                'custom_metadata' => [
                    'product_id' => $product->id,
                    'buyer_id' => $user->id,
                ]
            ]);

            $token = $transaction->generateToken();
            Log::info('Token generated, redirecting to: ' . $token->url);

            return redirect($token->url);
        } catch (\Exception $e) {
            Log::error('FedaPay Error: ' . $e->getMessage());
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
            Log::info('Transaction retrieved. Real status: ' . $transaction->status);

            // Log everything into payments_logs
            $metadata = $transaction->custom_metadata;
            $productId = $metadata['product_id'] ?? null;
            $buyerId = $metadata['buyer_id'] ?? null;

            PaymentLog::create([
                'transaction_id' => $transactionId,
                'status' => $transaction->status,
                'payload' => json_decode(json_encode($transaction), true),
                'product_id' => $productId,
                'buyer_id' => $buyerId,
            ]);

            // Accept both 'approved' (instant) and 'pending' (mobile money en cours de traitement).
            // The webhook handles the final 'approved' confirmation for pending ones.
            $isPaymentSubmitted = in_array($transaction->status, ['approved', 'pending']) ||
                in_array($status, ['approved', 'pending']);

            if ($isPaymentSubmitted) {
                if ($productId && $buyerId) {
                    $product = Product::find($productId);

                    // Prevent duplicate sales
                    $existingSale = Sale::where('product_id', $productId)
                        ->where('buyer_id', $buyerId)
                        ->whereIn('status', ['escrow_locked', 'pending'])
                        ->first();

                    if (!$existingSale) {
                        // Use 'pending' status if payment not yet approved, 'escrow_locked' if approved
                        $saleStatus = ($transaction->status === 'approved') ? 'escrow_locked' : 'pending';

                        Sale::create([
                            'product_id' => $product->id,
                            'seller_id' => $product->user_id,
                            'buyer_id' => $buyerId,
                            'amount' => $product->prix,
                            'status' => $saleStatus,
                        ]);

                        Log::info("Sale recorded with status: $saleStatus.");
                    } else {
                        Log::warning('Sale already exists for this transaction.');
                    }

                    if ($transaction->status === 'approved') {
                        return redirect()->route('client.purchases')->with('success', 'Paiement réussi ! Votre achat a été enregistré.');
                    } else {
                        // Pending: payment submitted, waiting for mobile money confirmation
                        return redirect()->route('client.purchases')->with('success', 'Paiement soumis ! Votre achat sera confirmé sous peu.');
                    }
                }
            }

            Log::warning('Transaction was not approved or pending. Status: ' . $transaction->status);
            return redirect()->route('explorer')->with('error', 'Le paiement a échoué ou a été annulé.');
        } catch (\Exception $e) {
            Log::error('Callback Verification Error: ' . $e->getMessage());

            // Optionally log the error even if retrieval failed
            PaymentLog::create([
                'transaction_id' => $transactionId,
                'status' => 'error',
                'payload' => ['error' => $e->getMessage(), 'raw_status' => $status ?? null],
            ]);

            return redirect()->route('explorer')->with('error', 'Une erreur est survenue lors de la vérification du paiement.');
        }
    }

    /**
     * [NOUVEAU] Affiche notre page de paiement intégrée (checkout.js)
     * Route: GET /pay/{productId}
     */
    public function showCheckout(int $productId)
    {
        $product = Product::findOrFail($productId);
        $publicKey = config('fedapay.public_key');
        $callbackUrl = route('client.callback');

        return view('Client.checkout', compact('product', 'publicKey', 'callbackUrl'));
    }

    /**
     * [NOUVEAU] Endpoint AJAX — crée la transaction FedaPay et retourne le token
     * Route: POST /pay/initiate (throttle:10,1)
     * La clé secrète ne quitte JAMAIS le serveur.
     */
    public function initiateCheckout(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|integer|exists:products,id',
        ]);

        $user = Auth::user();
        $product = Product::findOrFail($validated['product_id']);

        \FedaPay\FedaPay::setApiKey(config('fedapay.secret_key'));
        \FedaPay\FedaPay::setEnvironment(config('fedapay.environment'));

        try {
            Log::info("[Checkout.js] Initiation transaction pour produit #{$product->id} par user #{$user->id}");

            $transaction = \FedaPay\Transaction::create([
                'description' => 'Achat de : ' . $product->nom,
                'amount' => (int) $product->prix,
                'currency' => ['iso' => 'XOF'],
                'callback_url' => route('client.callback'),
                'customer' => [
                    'firstname' => $user->firstname,
                    'lastname' => $user->lastname,
                    'email' => $user->email,
                ],
                'custom_metadata' => [
                    'product_id' => $product->id,
                    'buyer_id' => $user->id,
                ],
            ]);

            $token = $transaction->generateToken();

            Log::info("[Checkout.js] Token généré pour transaction #{$transaction->id}");

            return response()->json([
                'success' => true,
                'token' => $token->token,
            ]);
        } catch (\Exception $e) {
            Log::error('[Checkout.js] Erreur initiation : ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => "Erreur lors de l'initialisation du paiement : " . $e->getMessage(),
            ], 500);
        }
    }
}
