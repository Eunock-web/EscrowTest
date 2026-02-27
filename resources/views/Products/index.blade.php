@extends('layouts.app')

@section('title', 'PixelVault — Mes Produits')

@section('content')
    <!-- Header -->
    <header class="flex items-center justify-between mb-10 animate-fade" style="animation-delay: 0.1s;">
        <div>
            <h2 class="text-3xl font-extrabold text-white">Mes Produits <span class="text-slate-500 font-normal text-xl ml-2">({{ count($products) }})</span></h2>
            <p class="text-slate-500 mt-1">Gérez et suivez les performances de vos créations numériques.</p>
        </div>

        <div class="flex items-center gap-4">
            <a href="{{ route('createProduct') }}" class="bg-linear-to-r from-purple-600 to-blue-600 hover:from-purple-500 hover:to-blue-500 text-white font-bold py-3 px-6 rounded-xl flex items-center gap-2 shadow-lg shadow-purple-500/20 transition-all hover:scale-[1.02] active:scale-[0.98]">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Ajouter un produit
            </a>
            
            <div class="flex items-center gap-3 glass p-1.5 pr-4 rounded-xl border border-white/10">
                <div class="w-10 h-10 rounded-lg bg-linear-to-tr from-purple-500 to-blue-500 flex items-center justify-center font-bold text-white shadow-lg shadow-purple-500/20 uppercase">
                    {{ substr(Auth::user()->firstname, 0, 1) }}{{ substr(Auth::user()->lastname, 0, 1) }}
                </div>
            </div>
        </div>
    </header>

    <!-- Filters/Stats (Optional but looks premium) -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10 animate-fade" style="animation-delay: 0.2s;">
        <div class="glass p-6 rounded-2xl border border-white/5">
            <p class="text-xs text-slate-500 uppercase tracking-widest font-bold mb-1">Actifs</p>
            <h4 class="text-2xl font-bold text-white">{{ count($products) }} <span class="text-xs text-emerald-400 font-normal">En ligne</span></h4>
        </div>
        <div class="glass p-6 rounded-2xl border border-white/5">
            <p class="text-xs text-slate-500 uppercase tracking-widest font-bold mb-1">Vues Totales</p>
            <h4 class="text-2xl font-bold text-white">1,240 <span class="text-xs text-blue-400 font-normal">Consultations</span></h4>
        </div>
        <div class="glass p-6 rounded-2xl border border-white/5">
            <p class="text-xs text-slate-500 uppercase tracking-widest font-bold mb-1">Conversion Moy.</p>
            <h4 class="text-2xl font-bold text-white">4.2% <span class="text-xs text-purple-400 font-normal">Taux moyen</span></h4>
        </div>
    </div>

    <!-- Products Grid -->
    <div class="animate-fade" style="animation-delay: 0.3s;">
        @if(count($products) > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($products as $product)
                    <div class="glass rounded-2xl overflow-hidden border border-white/5 group hover:border-purple-500/30 transition-all duration-500">
                        <!-- Product Image -->
                        <div class="relative h-48 bg-slate-800 overflow-hidden">
                            @if($product->url_image)
                                <img src="{{ asset('storage/' . $product->url_image) }}" alt="{{ $product->nom }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-4xl">📦</div>
                            @endif
                            <div class="absolute inset-0 bg-linear-to-t from-[#050509] to-transparent opacity-60"></div>
                            <div class="absolute top-4 right-4">
                                <span class="px-3 py-1 bg-black/40 backdrop-blur-md text-white text-[10px] font-bold uppercase rounded-lg border border-white/10 italic">
                                    {{ $product->categorie->categorie ?? 'Général' }}
                                </span>
                            </div>
                        </div>

                        <!-- Product Info -->
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="text-lg font-bold text-white group-hover:text-purple-400 transition-colors">{{ $product->nom }}</h3>
                                <span class="text-lg font-extrabold text-white">{{ number_format($product->prix, 2) }}€</span>
                            </div>

                            <p class="text-sm text-slate-500 line-clamp-2 mb-6">
                                {{ $product->description }}
                            </p>

                            <div class="flex items-center gap-2 pt-4 border-t border-white/5">
                                <a href="{{ route('updateProducts', $product->id) }}" class="flex-1 text-center py-2.5 bg-white/5 hover:bg-white/10 text-white text-xs font-bold rounded-lg transition-all">
                                    Éditer
                                </a>
                                <button class="p-2.5 bg-red-400/10 hover:bg-red-400/20 text-red-400 rounded-lg transition-all group/delete">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Empty State -->
            <div class="glass rounded-3xl p-16 text-center border-dashed border-2 border-white/5">
                <div class="w-20 h-20 bg-slate-800 rounded-2xl flex items-center justify-center text-3xl mx-auto mb-6">🏜️</div>
                <h3 class="text-2xl font-bold text-white mb-2">Aucun produit pour le moment</h3>
                <p class="text-slate-500 mb-8 max-w-sm mx-auto">Commencez par ajouter votre première création numérique pour la vendre sur PixelVault.</p>
                <a href="{{ route('createProduct') }}" class="inline-flex items-center gap-2 px-8 py-3 bg-white text-black font-bold rounded-xl hover:bg-slate-200 transition-all">
                    Créer mon premier produit
                </a>
            </div>
        @endif
    </div>
@endsection
