<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Products\CreateProductRequest;
use App\Models\Product;
use App\Models\Categorie;

class ProductController extends Controller
{
    //Fonction pour la creation d'un produit
    public function create(CreateProductRequest $request){
        //Validation des données reçues
        $validatedData = $request->validated();
        $validatedData['user_id'] = Auth::id();

        $categorie = Categorie::create($validatedData['categorie']);
        if (!$categorie){

        }
        if($request->hasFile('image')){
            $image = $request->file('image');

            //Enregistrement physique de l'image
            $filename = time() . '' . $image->getClientOriginalExtension();
            $path = $image->storeAs('Products', $filename, 'public');
            $validatedData['url_image'] = $path;
        }

        //Creation maintenant du produit
        $product = Product::create($validatedData);

        if(!$product){
            return redirect('')->with();
        }else{
            
        }
    }

    //Fonction lister les produits
    public function index(){
        $products = Product::all();

        if(!$products){

        }
    }

    //Fonction pour la recherche d'un produit specifique
    public function searchProduct($productId){
        $product = Product::findOrFail($productId);

        if(!$product){

        }
    }

    //Fonction pour la suppression d'un produit
    public function deleteProduct($productId){
        $product = Product::findOrFail($productId);

        if(!$product){

        }

        $productDelete = $product->delete();

        if(!$productDelete){

        }
    }

    //Fonction pour la mis a jour d'un produit
    public function updateProduct($productId){

    }
}
