@extends('layouts.app')

@section('title', $product->nom . ' — PixelVault')

@section('styles')
<style>
    .glass { background: rgba(255, 255, 255, 0.03); backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.06); }
    .product-img-container {
        height: 400px;
        background: #111118;
        border-radius: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        border: 1px solid var(--c-border);
    }
    .grad-text {
      background: linear-gradient(135deg, #a78bfa 0%, #22d3ee 50%, #f59e0b 100%);
      -webkit-background-clip: text; -webkit-text-fill-color: transparent;
    }
</style>
@endsection

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="mb-8">
        <a href="{{ route('explorer') }}" class="text-slate-400 hover:text-white transition-colors flex items-center gap-2 text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Retour à l'exploration
        </a>
    </div>

    <div class="grid lg:grid-cols-2 gap-12">
        <!-- Left: Image -->
        <div class="product-img-container">
            @if($product->url_image)
                <img src="{{ asset('storage/' . $product->url_image) }}" alt="{{ $product->nom }}" class="w-full h-full object-cover">
            @else
                <svg class="w-24 h-24 text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            @endif
        </div>

        <!-- Right: Details -->
        <div>
            <div class="text-sm font-medium text-violet-400 mb-2 uppercase tracking-widest">{{ $product->categorie->nom ?? 'Produit' }}</div>
            <h1 class="font-display text-4xl font-800 text-white mb-4">{{ $product->nom }}</h1>
            
            <div class="flex items-center gap-4 mb-8">
                <div class="stars text-amber-400">★★★★★</div>
                <span class="text-slate-400 text-sm">4.9 • 128 ventes</span>
            </div>

            <div class="glass p-6 rounded-2xl mb-8">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-slate-400">Prix</span>
                    <span class="text-3xl font-800 text-white">{{ number_format($product->prix, 2) }}€</span>
                </div>
                <!-- Button for FedaPay integration (User requested to handle it) -->
                <button class="w-full btn-primary text-white py-4 rounded-xl font-bold flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-16M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    Acheter maintenant
                </button>
            </div>

            <div class="space-y-6">
                <div>
                    <h3 class="font-display text-white font-600 mb-2">Description</h3>
                    <p class="text-slate-400 leading-relaxed">
                        {{ $product->description ?? "Aucune description disponible pour ce produit." }}
                    </p>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="glass p-4 rounded-xl">
                        <div class="text-xs text-slate-500 mb-1">Vendeur</div>
                        <div class="text-sm font-medium text-white">Pixel Creator</div>
                    </div>
                    <div class="glass p-4 rounded-xl">
                        <div class="text-xs text-slate-500 mb-1">Livraison</div>
                        <div class="text-sm font-medium text-emerald-400">Instantanée</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
