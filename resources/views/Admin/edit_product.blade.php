@extends('layouts.app')

@section('title', 'Modifier le ' . 'Produit — Administration')

@section('content')
    <header class="flex items-center justify-between mb-10">
        <div>
            <h2 class="text-3xl font-extrabold text-white">Modifier le Produit</h2>
            <p class="text-slate-500 mt-1">Gérer les détails de l'actif numérique.</p>
        </div>
        <a href="{{ route('admin.products') }}" class="text-sm font-bold text-slate-400 hover:text-white transition-colors">
            &larr; Retour à la liste
        </a>
    </header>

    <div class="glass p-8 rounded-3xl max-w-2xl">
        <form action="{{ route('admin.products.update', $product->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label class="block text-sm font-bold text-slate-400 mb-2">Nom du Produit</label>
                <input type="text" name="nom" value="{{ old('nom', $product->nom) }}" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-violet-500" required>
                @error('nom')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-bold text-slate-400 mb-2">Catégorie</label>
                <select name="categorie_id" class="w-full bg-slate-900 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-violet-500" required>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $product->categorie_id == $category->id ? 'selected' : '' }}>
                            {{ $category->nom }}
                        </option>
                    @endforeach
                </select>
                @error('categorie_id')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-bold text-slate-400 mb-2">Prix (€)</label>
                <input type="number" step="0.01" name="prix" value="{{ old('prix', $product->prix) }}" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-violet-500" required>
                @error('prix')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-bold text-slate-400 mb-2">URL de l'image (Optionnel)</label>
                <input type="url" name="url_image" value="{{ old('url_image', $product->url_image) }}" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-violet-500" placeholder="https://...">
                @error('url_image')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="mb-8">
                <label class="block text-sm font-bold text-slate-400 mb-2">Description</label>
                <textarea name="description" rows="4" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-violet-500">{{ old('description', $product->description) }}</textarea>
                @error('description')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="flex justify-end gap-4">
                <a href="{{ route('admin.products') }}" class="px-6 py-3 rounded-xl font-bold text-slate-400 hover:text-white transition-colors border border-white/10 hover:bg-white/5">
                    Annuler
                </a>
                <button type="submit" class="bg-violet-600 hover:bg-violet-700 text-white font-bold py-3 px-6 rounded-xl transition-colors shadow-[0_0_15px_rgba(124,58,237,0.4)]">
                    Enregistrer les modifications
                </button>
            </div>
        </form>
    </div>
@endsection
