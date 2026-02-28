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


    /**
     * Creation of the client
     */
        public function createClient(){
            $user = Auth::user();
            $firstname = $user['firstname'];
            $lastname = $user['lastname'];
            $email = $user['email'];
            

            /* Replace YOUR_SECRETE_API_KEY with your secret API key */
\FedaPay\FedaPay::setApiKey("YOUR_SECRETE_API_KEY");
/* Specify whether you want to run your query in test or live mode */
\FedaPay\FedaPay::setEnvironment('sandbox'); //or setEnvironment('live');
/* Create customer */
\FedaPay\Customer::create(array(
  "firstname" => $firstname ,
  "lastname" => $lastname,
  "email" => $email,
));

        }

    /**
     * Starting escrow
     */

    public function Transaction($productId){
            $user = Auth::user();
            $firstname = $user['firstname'];
            $lastname = $user['lastname'];
            $email = $user['email'];


            //Recuperatioin des produits
            $products = Product::findOrFail($productId);

            if(!$products){
                return back()->withErrors([
                    'error'=> "Produit innexistant"
                ]);
            }

        \FedaPay\Fedapay::setApiKey('YOUR_API_KEY');
\FedaPay\Fedapay::setEnvironment('sandbox');
$transaction = \FedaPay\Transaction::create([
  'description' => $products['description'],
  'amount' => $products['prix'],
  'currency' => ['iso' => 'XOF'],
  'callback_url' => 'https://example.com/callback',
  // Si le client n'existe pas encore
  'customer' => [
      'firstname' => $firstname,
      'lastname' => $lastname,
      'email' => $email,
    //   'phone_number' => [
    //       'number' => '+22997808080',
    //       'country' => 'bj'
    //   ]
  ]
]);

$token = $transaction->generateToken();
return header('Location:'. $token->url());
    }
}
