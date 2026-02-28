@extends('layouts.app')

@section('title', 'PixelVault — Explorer la Boutique')

@section('styles')
<style>
    :root {
      --c-bg: #09090f;
      --c-surface: #111118;
      --c-border: #1e1e2e;
      --c-accent: #7c3aed;
      --c-accent2: #06b6d4;
      --c-gold: #f59e0b;
      --c-text: #e2e8f0;
      --c-muted: #64748b;
    }

    h1, h2, h3, h4, .font-display { font-family: 'Syne', sans-serif; }

    .grad-text {
      background: linear-gradient(135deg, #a78bfa 0%, #22d3ee 50%, #f59e0b 100%);
      -webkit-background-clip: text; -webkit-text-fill-color: transparent;
    }

    /* ---- SIDEBAR FILTER ---- */
    .filter-sidebar {
      background: var(--c-surface);
      border: 1px solid var(--c-border);
      border-radius: 20px;
      position: sticky;
      top: 24px;
    }

    .filter-section { border-bottom: 1px solid var(--c-border); }
    .filter-section:last-child { border-bottom: none; }

    .filter-checkbox {
      appearance: none;
      width: 16px; height: 16px;
      border: 1.5px solid #3f3f5a;
      border-radius: 4px;
      background: transparent;
      cursor: pointer;
      transition: all 0.2s;
      position: relative;
      flex-shrink: 0;
    }
    .filter-checkbox:checked {
      background: var(--c-accent);
      border-color: var(--c-accent);
    }
    .filter-checkbox:checked::after {
      content: '✓';
      position: absolute; inset: 0;
      display: flex; align-items: center; justify-content: center;
      color: white; font-size: 10px; font-weight: 700;
    }

    /* Range slider */
    .range-slider {
      -webkit-appearance: none;
      width: 100%; height: 3px;
      background: linear-gradient(to right, var(--c-accent) 0%, var(--c-accent) var(--val, 70%), #1e1e2e var(--val, 70%), #1e1e2e 100%);
      border-radius: 2px; cursor: pointer;
    }
    .range-slider::-webkit-slider-thumb {
      -webkit-appearance: none;
      width: 16px; height: 16px;
      border-radius: 50%;
      background: var(--c-accent);
      border: 2px solid rgba(124,58,237,0.5);
      box-shadow: 0 0 12px rgba(124,58,237,0.6);
      cursor: pointer;
    }

    /* ---- PRODUCT CARD ---- */
    .product-card {
      background: var(--c-surface);
      border: 1px solid var(--c-border);
      border-radius: 16px;
      overflow: hidden;
      transition: transform 0.3s ease, border-color 0.3s, box-shadow 0.3s;
      position: relative;
    }
    .product-card:hover { transform: translateY(-5px); border-color: rgba(124,58,237,0.35); box-shadow: 0 16px 50px rgba(124,58,237,0.12); }

    .card-img {
      height: 160px;
      display: flex; align-items: center; justify-content: center;
      position: relative; overflow: hidden;
    }

    .preview-btn {
      position: absolute; bottom: 10px; left: 50%; transform: translateX(-50%) translateY(8px);
      background: rgba(0,0,0,0.7); backdrop-filter: blur(8px);
      border: 1px solid rgba(255,255,255,0.1);
      color: white; font-size: 12px; font-weight: 500;
      padding: 5px 14px; border-radius: 20px;
      opacity: 0; transition: all 0.25s;
      white-space: nowrap; cursor: pointer;
    }
    .product-card:hover .preview-btn { opacity: 1; transform: translateX(-50%) translateY(0); }

    /* ---- SORT BAR ---- */
    .sort-bar {
      background: var(--c-surface);
      border: 1px solid var(--c-border);
      border-radius: 14px;
    }

    .sort-select {
      background: transparent;
      border: 1px solid var(--c-border);
      color: var(--c-text);
      border-radius: 10px;
      padding: 8px 12px;
      font-size: 13px;
      cursor: pointer;
      outline: none;
    }

    /* Search bar */
    .search-bar {
      background: rgba(255,255,255,0.04);
      border: 1px solid var(--c-border);
      border-radius: 12px;
    }
    .search-input {
      background: transparent;
      border: none; outline: none;
      color: var(--c-text);
      font-size: 14px; width: 100%;
    }

    /* Cat pills */
    .cat-pill {
      border: 1px solid var(--c-border);
      transition: all 0.2s; cursor: pointer;
      white-space: nowrap;
    }
    .cat-pill:hover, .cat-pill.active {
      border-color: var(--c-accent);
      background: rgba(124,58,237,0.15);
      color: #a78bfa;
    }

    /* Pagination mapping */
    .pagination-container nav div:first-child { display: none; }
    .pagination-container nav div:last-child {
        display: flex;
        justify-content: center;
        gap: 8px;
    }
    .pagination-container span, .pagination-container a {
        padding: 8px 16px;
        border-radius: 10px;
        border: 1px solid var(--c-border);
        background: var(--c-surface);
        color: var(--c-muted);
        transition: all 0.2s;
    }
    .pagination-container .active-page {
        background: var(--c-accent);
        border-color: var(--c-accent);
        color: white;
    }
</style>
@endsection

@section('content')
<div class="relative overflow-hidden mb-10">
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-6">
        <div>
            <h1 class="font-display text-4xl md:text-5xl font-800 text-white mb-3">
                Explorer la <span class="grad-text">boutique</span>
            </h1>
            <p class="text-slate-400">
                <span class="text-white font-medium">{{ $products->total() }}</span> produits digitaux premium disponibles
            </p>
        </div>
    </div>

    <!-- Category pills -->
    <div class="flex gap-2 overflow-x-auto pb-4 scrollbar-none">
        <a href="{{ route('explorer', ['category' => 'all', 'search' => request('search')]) }}" 
           class="cat-pill {{ request('category', 'all') == 'all' ? 'active' : '' }} text-sm px-4 py-2 rounded-full text-slate-400">
           Tout
        </a>
        @foreach($categories as $category)
            <a href="{{ route('explorer', ['category' => $category->id, 'search' => request('search')]) }}" 
               class="cat-pill {{ request('category') == $category->id ? 'active' : '' }} text-sm px-4 py-2 rounded-full text-slate-400">
               {{ $category->nom }}
            </a>
        @endforeach
    </div>
</div>

<div class="flex flex-col lg:flex-row gap-8">
    <!-- Sidebar Filters -->
    <aside class="w-full lg:w-72 shrink-0">
        <div class="filter-sidebar p-5">
            <form action="{{ route('explorer') }}" method="GET">
                <input type="hidden" name="category" value="{{ request('category', 'all') }}">
                
                <div class="filter-section pb-5 mb-5">
                    <div class="search-bar flex items-center gap-3 px-3 py-2.5">
                        <svg class="w-4 h-4 text-slate-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <input name="search" class="search-input text-sm" type="text" placeholder="Rechercher..." value="{{ request('search') }}"/>
                    </div>
                </div>

                <div class="filter-section pb-5 mb-5">
                    <span class="font-display text-white text-sm font-600 block mb-4">Prix Max</span>
                    <input type="range" class="range-slider w-full mb-3" min="0" max="1000" value="1000" id="priceRange"/>
                    <div class="flex justify-between text-xs text-slate-600">
                        <span>Gratuit</span>
                        <span>1000€+</span>
                    </div>
                </div>

                <button type="submit" class="w-full bg-violet-600 hover:bg-violet-700 text-white font-bold py-2 px-4 rounded-xl transition-colors">
                    Appliquer
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="flex-1">
        <!-- Sort bar -->
        <div class="sort-bar flex items-center justify-between px-4 py-3 mb-6">
            <div class="text-sm text-slate-400">
                Affichage de {{ $products->firstItem() }} - {{ $products->lastItem() }} sur {{ $products->total() }}
            </div>
        </div>

        <!-- Products Grid -->
        <div class="grid sm:grid-cols-2 xl:grid-cols-3 gap-6 mb-8">
            @foreach($products as $product)
                <div class="product-card group">
                    <div class="card-img bg-slate-800">
                        @if($product->url_image)
                            <img src="{{ asset('storage/' . $product->url_image) }}" alt="{{ $product->nom }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                        @else
                            <svg class="w-12 h-12 text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        @endif
                        <a href="{{ route('product.show', $product->id) }}" class="preview-btn">Voir détails ✦</a>
                    </div>
                    <div class="p-4">
                        <div class="text-xs font-medium text-violet-400 mb-1 uppercase tracking-wider">{{ $product->categorie->nom ?? 'Produit' }}</div>
                        <h3 class="font-display text-white font-600 text-sm mb-1.5 leading-snug truncate">{{ $product->nom }}</h3>
                        <div class="flex items-center justify-between mt-4">
                            <div>
                                <span class="text-white font-700 text-lg">{{ number_format($product->prix, 2) }}€</span>
                            </div>
                            <a href="{{ route('client.initTransaction', $product->id) }}" class="btn-primary text-white text-xs px-4 py-2 rounded-lg font-medium">
                                Acheter
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="pagination-container py-4">
            {{ $products->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection
