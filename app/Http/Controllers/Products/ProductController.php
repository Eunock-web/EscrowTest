<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Products\CreateProductRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Categorie;

class ProductController extends Controller
{
    public function showCreate(){
        $categories = Categorie::all();
        return view('Products.create', compact('categories'));
    }


    //Fonction pour la creation d'un produit
    public function create(CreateProductRequest $request){
        $validatedData = $request->validated();
        
        // Stock par défaut si non fourni (ex: produit numérique illimité)
        $validatedData['user_id'] = Auth::id();
        $validatedData['stock'] = $validatedData['stock'] ?? 999;

        if($request->hasFile('image')){
            $image = $request->file('image');
            // Enregistrement de l'image dans storage/app/public/Products
            $path = $image->store('Products', 'public');
            $validatedData['url_image'] = $path;
        }

        // Ajout de la valeur pour la colonne redondante 'categories' si elle existe en migration
        // On récupère le nom de la catégorie pour la cohérence
        $categorie = Categorie::find($validatedData['categorie_id']);
        $validatedData['categories'] = $categorie ? $categorie->categorie : 'Général';

        // Création du produit
        $product = Product::create($validatedData);

        if($product){
            return response()->json([
                'message' => 'Produit créé avec succès',
                'product' => $product
            ], 201);
        } else {
            return response()->json([
                'message' => 'Erreur lors de la création du produit'
            ], 500);
        }
    }

    //Fonction lister les produits
    public function index(){
        $products = Product::where('user_id', Auth::id())->get();
        $categories = Categorie::all();

        return view('Products.index', compact('products', 'categories'));
    }


    //Fonction pour la recherche d'un produit specifique
    public function searchProduct($productId){
        $product = Product::with('categorie')->findOrFail($productId);
        return response()->json($product);
    }

    //Fonction pour la suppression d'un produit
    public function deleteProduct($productId){
        $product = Product::findOrFail($productId);

        // Vérification sommaire de l'appartenance
        if($product->user_id !== Auth::id()){
            return response()->json(['message' => 'Non autorisé'], 403);
        }

        if($product->delete()){
             return response()->json(['message' => 'Produit supprimé']);
        }

        return response()->json(['message' => 'Erreur lors de la suppression'], 500);
    }

    //Fonction pour la mis a jour d'un produit
    public function updateProduct(Request $request, $productId){
        $product = Product::findOrFail($productId);

        if($product->user_id !== Auth::id()){
            return response()->json(['message' => 'Non autorisé'], 403);
        }

        // Si c'est une requête de mise à jour (POST/PUT)
        if ($request->isMethod('put') || $request->isMethod('post')) {
            $validatedData = $request->validate([
                'nom' => 'required|string|max:255',
                'description' => 'required|string',
                'prix' => 'required|numeric',
                'categorie_id' => 'required|exists:categories,id',
            ]);

            if($request->hasFile('image')){
                $image = $request->file('image');
                $path = $image->store('Products', 'public');
                $validatedData['url_image'] = $path;
            }

            $product->update($validatedData);
            return response()->json(['message' => 'Produit mis à jour successfully']);
        }

        // Sinon, on retourne la vue d'édition
        $categories = Categorie::all();
        return view('Products.create', compact('product', 'categories'));
    }
}
