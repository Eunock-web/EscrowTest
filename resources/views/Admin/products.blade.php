@extends('layouts.app')

@section('title', 'Produits — Administration')

@section('content')
    <header class="flex items-center justify-between mb-10">
        <div>
            <h2 class="text-3xl font-extrabold text-white">Modération des Produits</h2>
            <p class="text-slate-500 mt-1">Surveillez et gérez tous les actifs numériques de la plateforme.</p>
        </div>
    </header>

    <div class="glass rounded-3xl overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-white/5">
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-widest">Produit</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-widest">Créateur</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-widest">Catégorie</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-widest">Prix</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-widest text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @foreach($products as $product)
                    <tr class="hover:bg-white/[0.02] transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-slate-800 flex items-center justify-center">
                                    📦
                                </div>
                                <p class="text-sm font-bold text-white">{{ $product->nom }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-xs text-slate-400">@ {{ $product->user->pseudo }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-[10px] font-bold text-slate-500 uppercase border border-white/10 px-2 py-1 rounded">
                                {{ $product->categorie->nom }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm font-bold text-emerald-400">{{ number_format($product->prix, 2) }}€</p>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <button class="text-xs font-bold text-red-500/80 hover:text-red-500 transition-colors">Supprimer</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
        <div class="p-6 border-t border-white/5">
            {{ $products->links() }}
        </div>
    </div>
@endsection
