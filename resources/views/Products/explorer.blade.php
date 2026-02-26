<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>PixelVault — Explorer la Boutique</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,300&display=swap" rel="stylesheet"/>
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
    * { box-sizing: border-box; margin: 0; padding: 0; }
    html { scroll-behavior: smooth; }
    body {
      background-color: var(--c-bg);
      color: var(--c-text);
      font-family: 'DM Sans', sans-serif;
      overflow-x: hidden;
      cursor: none;
    }

    /* Custom cursor */
    .cursor {
      width: 12px; height: 12px;
      background: var(--c-accent2);
      border-radius: 50%;
      position: fixed; pointer-events: none; z-index: 9999;
      transform: translate(-50%, -50%);
      transition: width 0.2s, height 0.2s, background 0.2s;
      mix-blend-mode: screen;
    }
    .cursor-ring {
      width: 36px; height: 36px;
      border: 1.5px solid rgba(124,58,237,0.5);
      border-radius: 50%;
      position: fixed; pointer-events: none; z-index: 9998;
      transform: translate(-50%, -50%);
      transition: width 0.3s, height 0.3s, opacity 0.3s;
    }

    h1, h2, h3, h4, .font-display { font-family: 'Syne', sans-serif; }

    /* Noise overlay */
    body::before {
      content: '';
      position: fixed; inset: 0;
      background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.03'/%3E%3C/svg%3E");
      pointer-events: none; z-index: 1000; opacity: 0.4;
    }

    .grid-bg {
      background-image:
        linear-gradient(rgba(124,58,237,0.04) 1px, transparent 1px),
        linear-gradient(90deg, rgba(124,58,237,0.04) 1px, transparent 1px);
      background-size: 60px 60px;
    }

    .orb { position: absolute; border-radius: 50%; filter: blur(80px); pointer-events: none; }

    @keyframes fadeUp {
      from { opacity: 0; transform: translateY(24px); }
      to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeIn {
      from { opacity: 0; } to { opacity: 1; }
    }
    @keyframes shimmer {
      0%   { background-position: -200% 0; }
      100% { background-position: 200% 0; }
    }
    @keyframes spin-slow {
      from { transform: rotate(0deg); } to { transform: rotate(360deg); }
    }
    @keyframes pulse-ring {
      0%   { transform: scale(1);   opacity: 0.6; }
      100% { transform: scale(1.8); opacity: 0; }
    }
    @keyframes slideRight {
      from { opacity: 0; transform: translateX(-16px); }
      to   { opacity: 1; transform: translateX(0); }
    }
    @keyframes cardIn {
      from { opacity: 0; transform: translateY(20px) scale(0.97); }
      to   { opacity: 1; transform: translateY(0) scale(1); }
    }
    @keyframes progressFill {
      from { width: 0%; } to { width: var(--fill); }
    }

    .anim-fade-up { animation: fadeUp 0.6s ease forwards; }
    .delay-1 { animation-delay: 0.08s; opacity: 0; }
    .delay-2 { animation-delay: 0.18s; opacity: 0; }
    .delay-3 { animation-delay: 0.28s; opacity: 0; }
    .delay-4 { animation-delay: 0.38s; opacity: 0; }

    /* Buttons */
    .btn-primary {
      background: linear-gradient(135deg, #7c3aed, #5b21b6);
      position: relative; overflow: hidden;
      transition: transform 0.2s, box-shadow 0.2s;
    }
    .btn-primary::after {
      content: '';
      position: absolute; inset: 0;
      background: linear-gradient(105deg, transparent 40%, rgba(255,255,255,0.15) 50%, transparent 60%);
      background-size: 200% 100%;
      animation: shimmer 2.5s infinite;
    }
    .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 0 30px rgba(124,58,237,0.5); }

    .btn-outline {
      border: 1px solid rgba(124,58,237,0.4);
      transition: all 0.2s; background: transparent;
    }
    .btn-outline:hover {
      border-color: var(--c-accent2);
      background: rgba(6,182,212,0.08);
      box-shadow: 0 0 20px rgba(6,182,212,0.15);
    }

    /* Nav */
    nav { backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); }

    /* Grad text */
    .grad-text {
      background: linear-gradient(135deg, #a78bfa 0%, #22d3ee 50%, #f59e0b 100%);
      -webkit-background-clip: text; -webkit-text-fill-color: transparent;
    }

    /* Scrollbar */
    ::-webkit-scrollbar { width: 5px; }
    ::-webkit-scrollbar-track { background: var(--c-bg); }
    ::-webkit-scrollbar-thumb { background: rgba(124,58,237,0.4); border-radius: 3px; }

    /* Stars */
    .stars { color: var(--c-gold); }

    /* ---- SIDEBAR FILTER ---- */
    .sidebar {
      background: var(--c-surface);
      border: 1px solid var(--c-border);
      border-radius: 20px;
      position: sticky;
      top: 84px;
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
    .filter-checkbox:hover { border-color: var(--c-accent); }

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
      transition: box-shadow 0.2s;
    }
    .range-slider::-webkit-slider-thumb:hover { box-shadow: 0 0 20px rgba(124,58,237,0.8); }

    /* ---- PRODUCT CARD ---- */
    .product-card {
      background: var(--c-surface);
      border: 1px solid var(--c-border);
      border-radius: 16px;
      overflow: hidden;
      transition: transform 0.3s ease, border-color 0.3s, box-shadow 0.3s;
      position: relative;
    }
    .product-card::before {
      content: '';
      position: absolute; inset: 0;
      background: linear-gradient(135deg, rgba(124,58,237,0.05), rgba(6,182,212,0.03));
      opacity: 0; transition: opacity 0.3s; pointer-events: none;
    }
    .product-card:hover { transform: translateY(-5px); border-color: rgba(124,58,237,0.35); box-shadow: 0 16px 50px rgba(124,58,237,0.12); }
    .product-card:hover::before { opacity: 1; }

    .card-img {
      height: 160px;
      display: flex; align-items: center; justify-content: center;
      position: relative; overflow: hidden;
    }
    .card-img svg { transition: transform 0.3s; }
    .product-card:hover .card-img svg { transform: scale(1.1); }

    .wishlist-btn {
      position: absolute; top: 10px; right: 10px;
      width: 32px; height: 32px;
      background: rgba(0,0,0,0.5);
      backdrop-filter: blur(8px);
      border-radius: 8px;
      display: flex; align-items: center; justify-content: center;
      opacity: 0; transition: opacity 0.2s, background 0.2s;
      cursor: pointer; border: 1px solid rgba(255,255,255,0.08);
    }
    .product-card:hover .wishlist-btn { opacity: 1; }
    .wishlist-btn:hover { background: rgba(124,58,237,0.4); }
    .wishlist-btn.active { opacity: 1; background: rgba(239,68,68,0.3); }
    .wishlist-btn.active svg { color: #f87171; fill: #f87171; }

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
      font-family: 'DM Sans', sans-serif;
      cursor: pointer;
      outline: none;
      transition: border-color 0.2s;
    }
    .sort-select:hover, .sort-select:focus { border-color: rgba(124,58,237,0.5); }
    .sort-select option { background: #111118; }

    /* Grid/List toggle */
    .view-btn {
      width: 34px; height: 34px;
      border-radius: 8px; border: 1px solid var(--c-border);
      display: flex; align-items: center; justify-content: center;
      cursor: pointer; transition: all 0.2s;
      color: #64748b;
    }
    .view-btn.active, .view-btn:hover {
      background: rgba(124,58,237,0.15);
      border-color: rgba(124,58,237,0.4);
      color: #a78bfa;
    }

    /* Search bar */
    .search-bar {
      background: rgba(255,255,255,0.04);
      border: 1px solid var(--c-border);
      border-radius: 12px;
      transition: border-color 0.2s, box-shadow 0.2s;
    }
    .search-bar:focus-within {
      border-color: rgba(124,58,237,0.5);
      box-shadow: 0 0 0 3px rgba(124,58,237,0.08);
    }
    .search-input {
      background: transparent;
      border: none; outline: none;
      color: var(--c-text);
      font-family: 'DM Sans', sans-serif;
      font-size: 14px; width: 100%;
    }
    .search-input::placeholder { color: #64748b; }

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

    /* Pagination */
    .page-btn {
      width: 36px; height: 36px;
      border-radius: 9px;
      border: 1px solid var(--c-border);
      display: flex; align-items: center; justify-content: center;
      cursor: pointer; transition: all 0.2s;
      color: #64748b; font-size: 13px; font-weight: 500;
      font-family: 'Syne', sans-serif;
    }
    .page-btn:hover { border-color: rgba(124,58,237,0.4); color: #a78bfa; background: rgba(124,58,237,0.08); }
    .page-btn.active { background: var(--c-accent); border-color: var(--c-accent); color: white; box-shadow: 0 0 16px rgba(124,58,237,0.4); }

    /* Modal overlay */
    .modal-overlay {
      position: fixed; inset: 0; z-index: 200;
      background: rgba(0,0,0,0.8);
      backdrop-filter: blur(8px);
      display: flex; align-items: center; justify-content: center;
      opacity: 0; pointer-events: none;
      transition: opacity 0.3s;
    }
    .modal-overlay.open { opacity: 1; pointer-events: all; }
    .modal-box {
      background: #111118;
      border: 1px solid rgba(124,58,237,0.3);
      border-radius: 24px;
      max-width: 640px; width: 90%;
      transform: scale(0.95) translateY(20px);
      transition: transform 0.3s;
      max-height: 90vh; overflow-y: auto;
    }
    .modal-overlay.open .modal-box { transform: scale(1) translateY(0); }

    /* Toast */
    .toast {
      position: fixed; bottom: 24px; right: 24px; z-index: 300;
      background: var(--c-surface);
      border: 1px solid rgba(124,58,237,0.4);
      border-radius: 14px;
      padding: 12px 18px;
      display: flex; align-items: center; gap-10px;
      transform: translateY(80px); opacity: 0;
      transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
      box-shadow: 0 8px 32px rgba(0,0,0,0.4);
      pointer-events: none;
    }
    .toast.show { transform: translateY(0); opacity: 1; }

    /* Badge */
    .badge-glow {
      animation: pulse-ring 1.8s ease-out infinite;
      position: absolute; inset: 0; border-radius: inherit;
      border: 1px solid var(--c-accent);
    }

    /* Progress bar */
    .progress-bar {
      height: 4px; border-radius: 2px;
      background: var(--c-border);
      overflow: hidden;
    }
    .progress-fill {
      height: 100%;
      background: linear-gradient(90deg, var(--c-accent), var(--c-accent2));
      border-radius: 2px;
      animation: progressFill 1s ease forwards;
    }

    /* List view card */
    .product-card-list {
      background: var(--c-surface);
      border: 1px solid var(--c-border);
      border-radius: 14px;
      overflow: hidden;
      display: flex;
      transition: transform 0.3s ease, border-color 0.3s, box-shadow 0.3s;
    }
    .product-card-list:hover { transform: translateX(4px); border-color: rgba(124,58,237,0.35); box-shadow: 0 8px 30px rgba(124,58,237,0.1); }

    /* Active filter tag */
    .filter-tag {
      background: rgba(124,58,237,0.15);
      border: 1px solid rgba(124,58,237,0.3);
      border-radius: 20px;
      padding: 4px 10px;
      font-size: 12px;
      color: #a78bfa;
      display: inline-flex; align-items: center; gap: 4px;
      cursor: pointer; transition: all 0.2s;
    }
    .filter-tag:hover { background: rgba(239,68,68,0.15); border-color: rgba(239,68,68,0.3); color: #f87171; }

    /* Shimmer loading skeleton */
    @keyframes skeletonWave {
      0%   { background-position: -400px 0; }
      100% { background-position: 400px 0; }
    }
    .skeleton {
      background: linear-gradient(90deg, #1e1e2e 25%, #2a2a3e 50%, #1e1e2e 75%);
      background-size: 800px 100%;
      animation: skeletonWave 1.8s infinite linear;
      border-radius: 8px;
    }
  </style>
</head>
<body class="grid-bg">

  <!-- Custom Cursor -->
  <div class="cursor" id="cursor"></div>
  <div class="cursor-ring" id="cursorRing"></div>

  <!-- Toast notification -->
  <div class="toast" id="toast">
    <div class="flex items-center gap-3">
      <div class="w-8 h-8 rounded-full bg-linear-to-br from-emerald-400 to-cyan-500 flex items-center justify-center shrink-0">
        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
      </div>
      <div>
        <div class="text-white text-sm font-medium" id="toastMsg">Ajouté au panier !</div>
        <div class="text-slate-500 text-xs">Livraison instantanée</div>
      </div>
    </div>
  </div>

  <!-- Quick View Modal -->
  <div class="modal-overlay" id="modal">
    <div class="modal-box" id="modalBox">
      <div class="p-6">
        <div class="flex items-start justify-between mb-6">
          <div>
            <div class="text-xs font-medium text-violet-400 mb-1" id="modalCategory">UI KIT</div>
            <h2 class="font-display text-2xl font-700 text-white" id="modalTitle">SaaS Dashboard Pro</h2>
          </div>
          <button onclick="closeModal()" class="w-8 h-8 rounded-lg border border-white/10 flex items-center justify-center text-slate-400 hover:text-white hover:border-white/30 transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
          </button>
        </div>

        <!-- Modal preview -->
        <div class="h-48 rounded-xl mb-6 flex items-center justify-center" id="modalPreviewBg">
          <svg class="w-16 h-16 text-violet-400" id="modalIcon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5z"/></svg>
        </div>

        <!-- Rating -->
        <div class="flex items-center gap-3 mb-4">
          <div class="stars text-base">★★★★★</div>
          <span class="text-slate-400 text-sm" id="modalRating">4.9 • 312 avis</span>
        </div>

        <!-- Description -->
        <p class="text-slate-400 text-sm leading-relaxed mb-5" id="modalDesc">
          Un kit UI premium avec plus de 400 composants soigneusement conçus pour vos projets SaaS. Inclut des variantes dark/light, des graphiques animés, des tableaux de données et bien plus encore.
        </p>

        <!-- Tags -->
        <div class="flex flex-wrap gap-2 mb-6">
          <span class="text-xs px-3 py-1 rounded-full border border-violet-500/30 text-violet-400 bg-violet-500/10">Figma</span>
          <span class="text-xs px-3 py-1 rounded-full border border-cyan-500/30 text-cyan-400 bg-cyan-500/10">React</span>
          <span class="text-xs px-3 py-1 rounded-full border border-white/10 text-slate-400">Dark Mode</span>
          <span class="text-xs px-3 py-1 rounded-full border border-white/10 text-slate-400">400+ composants</span>
        </div>

        <!-- What's included -->
        <div class="bg-white/3 rounded-xl p-4 mb-6 border border-white/5">
          <div class="text-white text-sm font-600 font-display mb-3">Ce qui est inclus</div>
          <div class="grid grid-cols-2 gap-2">
            <div class="flex items-center gap-2 text-slate-400 text-sm"><svg class="w-3.5 h-3.5 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>Fichier Figma source</div>
            <div class="flex items-center gap-2 text-slate-400 text-sm"><svg class="w-3.5 h-3.5 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>Composants React</div>
            <div class="flex items-center gap-2 text-slate-400 text-sm"><svg class="w-3.5 h-3.5 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>Mises à jour gratuites</div>
            <div class="flex items-center gap-2 text-slate-400 text-sm"><svg class="w-3.5 h-3.5 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>Licence commerciale</div>
          </div>
        </div>

        <div class="flex items-center justify-between">
          <div>
            <span class="text-white font-800 text-2xl font-display" id="modalPrice">49€</span>
            <span class="text-slate-600 text-sm line-through ml-2" id="modalOldPrice">89€</span>
          </div>
          <button onclick="addToCart(); closeModal();" class="btn-primary text-white px-7 py-3 rounded-xl font-medium text-sm flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-16M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            Ajouter au panier
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- ===== NAV ===== -->
  <nav class="fixed top-0 inset-x-0 z-50 border-b border-white/5 bg-[#09090f]/80">
    <div class="max-w-7xl mx-auto px-6 h-16 flex items-center justify-between">
      <a href="index.html" class="flex items-center gap-2">
        <div class="w-8 h-8 rounded-lg bg-linear-to-br from-violet-600 to-cyan-500 flex items-center justify-center">
          <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z"/></svg>
        </div>
        <span class="font-display text-lg font-700 text-white tracking-tight">Pixel<span class="grad-text">Vault</span></span>
      </a>

      <!-- Search -->
      <div class="hidden md:flex flex-1 max-w-sm mx-8">
        <div class="search-bar flex items-center gap-3 px-4 py-2.5 w-full">
          <svg class="w-4 h-4 text-slate-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
          <input class="search-input" type="text" placeholder="Rechercher des produits..." id="navSearch"/>
          <span class="text-xs text-slate-600 border border-white/10 rounded px-1.5 py-0.5 shrink-0">⌘K</span>
        </div>
      </div>

      <div class="hidden md:flex items-center gap-8 text-sm text-slate-400">
        <a href="/" class="hover:text-white transition-colors">Accueil</a>
        <a href="/explorer" class="text-violet-400 font-medium">Explorer</a>
        <a href="/createurs" class="hover:text-white transition-colors">Créateurs</a>
      </div>

      <div class="flex items-center gap-3">
        <!-- Cart indicator -->
        <button class="relative w-9 h-9 rounded-lg border border-white/10 flex items-center justify-center text-slate-400 hover:text-white hover:border-white/20 transition-all" id="cartBtn">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-16M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
          <span class="absolute -top-1 -right-1 w-4 h-4 bg-violet-500 rounded-full text-white text-xs flex items-center justify-center font-medium" id="cartCount" style="display:none">0</span>
        </button>
        <button class="btn-primary text-white text-sm px-5 py-2 rounded-lg font-medium">Commencer</button>
      </div>
    </div>
  </nav>

  <!-- ===== PAGE HEADER ===== -->
  <div class="relative pt-16 overflow-hidden">
    <div class="orb" style="width:500px;height:300px;background:rgba(124,58,237,0.12);top:-100px;left:-80px;"></div>
    <div class="orb" style="width:300px;height:300px;background:rgba(6,182,212,0.08);top:0;right:0;"></div>

    <div class="max-w-7xl mx-auto px-6 py-10 pb-6">
      <!-- Breadcrumb -->
      <div class="anim-fade-up delay-1 flex items-center gap-2 text-sm text-slate-500 mb-6">
        <a href="index.html" class="hover:text-slate-300 transition-colors">Accueil</a>
        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <span class="text-violet-400">Explorer la boutique</span>
      </div>

      <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-6">
        <div>
          <h1 class="anim-fade-up delay-2 font-display text-4xl md:text-5xl font-800 text-white mb-3">
            Explorer la <span class="grad-text">boutique</span>
          </h1>
          <p class="anim-fade-up delay-3 text-slate-400">
            <span id="resultCount" class="text-white font-medium">2 481</span> produits digitaux premium disponibles
          </p>
        </div>

        <!-- Active filters -->
        <div class="anim-fade-up delay-4 flex flex-wrap gap-2" id="activeFilters">
          <span class="filter-tag" onclick="removeFilter(this)">
            UI Kits <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
          </span>
          <span class="filter-tag" onclick="removeFilter(this)">
            -50% <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
          </span>
          <button class="text-xs text-slate-500 hover:text-slate-300 transition-colors px-2" onclick="clearFilters()">Tout effacer</button>
        </div>
      </div>

      <!-- Category pills horizontal scroll -->
      <div class="flex gap-2 overflow-x-auto pb-2 scrollbar-none" style="scrollbar-width:none">
        <button class="cat-pill active text-sm px-4 py-2 rounded-full text-slate-400">Tout</button>
        <button class="cat-pill text-sm px-4 py-2 rounded-full text-slate-400">🎨 UI Kits</button>
        <button class="cat-pill text-sm px-4 py-2 rounded-full text-slate-400">📄 Templates</button>
        <button class="cat-pill text-sm px-4 py-2 rounded-full text-slate-400">📚 Cours</button>
        <button class="cat-pill text-sm px-4 py-2 rounded-full text-slate-400">🔌 Plugins</button>
        <button class="cat-pill text-sm px-4 py-2 rounded-full text-slate-400">🖼 Illustrations</button>
        <button class="cat-pill text-sm px-4 py-2 rounded-full text-slate-400">🎵 Audio</button>
        <button class="cat-pill text-sm px-4 py-2 rounded-full text-slate-400">🎬 Vidéo</button>
        <button class="cat-pill text-sm px-4 py-2 rounded-full text-slate-400">⚙️ Scripts</button>
        <button class="cat-pill text-sm px-4 py-2 rounded-full text-slate-400">📦 Bundles</button>
      </div>
    </div>
  </div>

  <!-- ===== MAIN CONTENT ===== -->
  <div class="max-w-7xl mx-auto px-6 pb-24">
    <div class="flex gap-6">

      <!-- ===== SIDEBAR ===== -->
      <aside class="hidden lg:block w-72 shrink-0">
        <div class="sidebar p-5">

          <!-- Search in sidebar -->
          <div class="filter-section pb-5 mb-5">
            <div class="search-bar flex items-center gap-3 px-3 py-2.5">
              <svg class="w-4 h-4 text-slate-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
              <input class="search-input text-sm" type="text" placeholder="Rechercher..."/>
            </div>
          </div>

          <!-- Categories -->
          <div class="filter-section pb-5 mb-5">
            <div class="flex items-center justify-between mb-4">
              <span class="font-display text-white text-sm font-600">Catégories</span>
              <button class="text-xs text-violet-400 hover:text-violet-300 transition-colors">Tout</button>
            </div>
            <div class="space-y-2.5">
              <label class="flex items-center gap-3 cursor-pointer group">
                <input type="checkbox" class="filter-checkbox" checked/>
                <span class="text-slate-400 text-sm group-hover:text-slate-200 transition-colors flex-1">UI Kits</span>
                <span class="text-xs text-slate-600 bg-white/5 px-2 py-0.5 rounded-full">312</span>
              </label>
              <label class="flex items-center gap-3 cursor-pointer group">
                <input type="checkbox" class="filter-checkbox"/>
                <span class="text-slate-400 text-sm group-hover:text-slate-200 transition-colors flex-1">Templates</span>
                <span class="text-xs text-slate-600 bg-white/5 px-2 py-0.5 rounded-full">487</span>
              </label>
              <label class="flex items-center gap-3 cursor-pointer group">
                <input type="checkbox" class="filter-checkbox"/>
                <span class="text-slate-400 text-sm group-hover:text-slate-200 transition-colors flex-1">Cours en ligne</span>
                <span class="text-xs text-slate-600 bg-white/5 px-2 py-0.5 rounded-full">145</span>
              </label>
              <label class="flex items-center gap-3 cursor-pointer group">
                <input type="checkbox" class="filter-checkbox"/>
                <span class="text-slate-400 text-sm group-hover:text-slate-200 transition-colors flex-1">Plugins</span>
                <span class="text-xs text-slate-600 bg-white/5 px-2 py-0.5 rounded-full">203</span>
              </label>
              <label class="flex items-center gap-3 cursor-pointer group">
                <input type="checkbox" class="filter-checkbox"/>
                <span class="text-slate-400 text-sm group-hover:text-slate-200 transition-colors flex-1">Illustrations</span>
                <span class="text-xs text-slate-600 bg-white/5 px-2 py-0.5 rounded-full">89</span>
              </label>
              <label class="flex items-center gap-3 cursor-pointer group">
                <input type="checkbox" class="filter-checkbox"/>
                <span class="text-slate-400 text-sm group-hover:text-slate-200 transition-colors flex-1">Audio & SFX</span>
                <span class="text-xs text-slate-600 bg-white/5 px-2 py-0.5 rounded-full">67</span>
              </label>
            </div>
          </div>

          <!-- Price range -->
          <div class="filter-section pb-5 mb-5">
            <div class="flex items-center justify-between mb-4">
              <span class="font-display text-white text-sm font-600">Prix</span>
              <span class="text-violet-400 text-sm font-medium" id="priceLabel">0€ — 150€</span>
            </div>
            <input type="range" class="range-slider w-full mb-3" min="0" max="300" value="150" id="priceRange" oninput="updatePrice(this)"/>
            <div class="flex justify-between text-xs text-slate-600">
              <span>Gratuit</span>
              <span>300€+</span>
            </div>
          </div>

          <!-- Rating -->
          <div class="filter-section pb-5 mb-5">
            <div class="font-display text-white text-sm font-600 mb-4">Note minimale</div>
            <div class="space-y-2">
              <label class="flex items-center gap-3 cursor-pointer group">
                <input type="radio" name="rating" class="filter-checkbox" checked style="border-radius:50%"/>
                <span class="stars text-sm">★★★★★</span>
                <span class="text-slate-500 text-xs">5.0</span>
              </label>
              <label class="flex items-center gap-3 cursor-pointer group">
                <input type="radio" name="rating" class="filter-checkbox" style="border-radius:50%"/>
                <span class="stars text-sm">★★★★☆</span>
                <span class="text-slate-500 text-xs">4.0+</span>
              </label>
              <label class="flex items-center gap-3 cursor-pointer group">
                <input type="radio" name="rating" class="filter-checkbox" style="border-radius:50%"/>
                <span class="stars text-sm">★★★☆☆</span>
                <span class="text-slate-500 text-xs">3.0+</span>
              </label>
            </div>
          </div>

          <!-- Promotions -->
          <div class="filter-section pb-5 mb-5">
            <div class="font-display text-white text-sm font-600 mb-4">Offres spéciales</div>
            <div class="space-y-2.5">
              <label class="flex items-center gap-3 cursor-pointer group">
                <input type="checkbox" class="filter-checkbox" checked/>
                <span class="text-slate-400 text-sm group-hover:text-slate-200 transition-colors">En promotion</span>
              </label>
              <label class="flex items-center gap-3 cursor-pointer group">
                <input type="checkbox" class="filter-checkbox"/>
                <span class="text-slate-400 text-sm group-hover:text-slate-200 transition-colors">Gratuit</span>
              </label>
              <label class="flex items-center gap-3 cursor-pointer group">
                <input type="checkbox" class="filter-checkbox"/>
                <span class="text-slate-400 text-sm group-hover:text-slate-200 transition-colors">Nouveautés</span>
              </label>
              <label class="flex items-center gap-3 cursor-pointer group">
                <input type="checkbox" class="filter-checkbox"/>
                <span class="text-slate-400 text-sm group-hover:text-slate-200 transition-colors">Bestsellers</span>
              </label>
            </div>
          </div>

          <!-- Formats -->
          <div class="mb-2">
            <div class="font-display text-white text-sm font-600 mb-4">Format</div>
            <div class="flex flex-wrap gap-2">
              <span class="cat-pill active text-xs px-3 py-1.5 rounded-full text-slate-400">Figma</span>
              <span class="cat-pill text-xs px-3 py-1.5 rounded-full text-slate-400">Sketch</span>
              <span class="cat-pill text-xs px-3 py-1.5 rounded-full text-slate-400">React</span>
              <span class="cat-pill text-xs px-3 py-1.5 rounded-full text-slate-400">Vue</span>
              <span class="cat-pill text-xs px-3 py-1.5 rounded-full text-slate-400">HTML</span>
              <span class="cat-pill text-xs px-3 py-1.5 rounded-full text-slate-400">SVG</span>
              <span class="cat-pill text-xs px-3 py-1.5 rounded-full text-slate-400">PDF</span>
            </div>
          </div>

        </div>

        <!-- Promo banner sidebar -->
        <div class="mt-4 p-5 rounded-2xl relative overflow-hidden" style="background: linear-gradient(135deg, rgba(124,58,237,0.2), rgba(6,182,212,0.1)); border: 1px solid rgba(124,58,237,0.3);">
          <div class="orb" style="width:120px;height:120px;background:rgba(124,58,237,0.3);top:-40px;right:-40px;filter:blur(40px)"></div>
          <div class="relative z-10">
            <div class="text-xs text-violet-300 font-medium mb-1">Offre limitée</div>
            <div class="font-display text-white font-700 text-lg leading-tight mb-2">Bundle Premium<br/>à -60%</div>
            <p class="text-slate-400 text-xs mb-4 leading-relaxed">Accès à +500 ressources premium pendant 1 an.</p>
            <button class="btn-primary text-white text-xs px-4 py-2 rounded-lg font-medium w-full">Découvrir →</button>
          </div>
        </div>
      </aside>

      <!-- ===== PRODUCTS GRID ===== -->
      <div class="flex-1 min-w-0">

        <!-- Sort bar -->
        <div class="sort-bar flex items-center justify-between px-4 py-3 mb-5 gap-4">
          <div class="flex items-center gap-3 text-sm text-slate-400">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"/></svg>
            <span class="hidden sm:inline">Trier par :</span>
            <select class="sort-select" id="sortSelect" onchange="sortProducts(this.value)">
              <option value="popular">Popularité</option>
              <option value="newest">Plus récents</option>
              <option value="price-asc">Prix croissant</option>
              <option value="price-desc">Prix décroissant</option>
              <option value="rating">Meilleures notes</option>
            </select>
          </div>

          <div class="flex items-center gap-2">
            <span class="text-slate-600 text-xs hidden sm:inline">Vue :</span>
            <button class="view-btn active" id="gridBtn" onclick="setView('grid')">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
            </button>
            <button class="view-btn" id="listBtn" onclick="setView('list')">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
            </button>
          </div>
        </div>

        <!-- Products Grid -->
        <div id="productsGrid" class="grid sm:grid-cols-2 xl:grid-cols-3 gap-4 mb-8">

          <!-- Cards data rendered by JS -->

        </div>

        <!-- Pagination -->
        <div class="flex items-center justify-center gap-2 mt-8">
          <button class="page-btn">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
          </button>
          <button class="page-btn active">1</button>
          <button class="page-btn" onclick="changePage(this)">2</button>
          <button class="page-btn" onclick="changePage(this)">3</button>
          <span class="text-slate-600 text-sm px-2">...</span>
          <button class="page-btn" onclick="changePage(this)">12</button>
          <button class="page-btn">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- ===== FOOTER ===== -->
  <footer class="border-t border-white/5 py-10">
    <div class="max-w-7xl mx-auto px-6">
      <div class="flex flex-col md:flex-row items-center justify-between gap-4 text-slate-600 text-xs">
        <div class="flex items-center gap-2">
          <div class="w-6 h-6 rounded-md bg-linear-to-br from-violet-600 to-cyan-500 flex items-center justify-center">
            <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z"/></svg>
          </div>
          <span class="font-display font-700 text-slate-400">Pixel<span class="grad-text">Vault</span></span>
        </div>
        <span>© 2024 PixelVault. Tous droits réservés.</span>
        <div class="flex gap-5">
          <a href="#" class="hover:text-slate-400 transition-colors">Confidentialité</a>
          <a href="#" class="hover:text-slate-400 transition-colors">CGU</a>
          <a href="index.html" class="hover:text-slate-400 transition-colors">Accueil</a>
        </div>
      </div>
    </div>
  </footer>

  <script>
    /* ===================== CURSOR ===================== */
    const cursor = document.getElementById('cursor');
    const ring   = document.getElementById('cursorRing');
    let mx = 0, my = 0, rx = 0, ry = 0;

    document.addEventListener('mousemove', e => {
      mx = e.clientX; my = e.clientY;
      cursor.style.left = mx + 'px';
      cursor.style.top  = my + 'px';
    });
    (function animRing() {
      rx += (mx - rx) * 0.12;
      ry += (my - ry) * 0.12;
      ring.style.left = rx + 'px';
      ring.style.top  = ry + 'px';
      requestAnimationFrame(animRing);
    })();

    document.querySelectorAll('a, button, input, select, label').forEach(el => {
      el.addEventListener('mouseenter', () => { cursor.style.width='20px'; cursor.style.height='20px'; ring.style.width='50px'; ring.style.height='50px'; });
      el.addEventListener('mouseleave', () => { cursor.style.width='12px'; cursor.style.height='12px'; ring.style.width='36px'; ring.style.height='36px'; });
    });

    /* ===================== PRODUCTS DATA ===================== */
    const products = [
      { id:1,  title:'SaaS Dashboard Pro',        category:'UI KIT',      categoryColor:'violet', price:49,  oldPrice:89,  rating:4.9, reviews:312, badge:'Bestseller', badgeColor:'violet', icon:'dashboard',  gradient:'from-violet-600/30 to-purple-900/30',  iconColor:'text-violet-400' },
      { id:2,  title:'Masterclass Next.js 14',    category:'COURS',       categoryColor:'cyan',   price:79,  oldPrice:null, rating:4.8, reviews:198, badge:null,          badgeColor:null,     icon:'book',       gradient:'from-cyan-600/30 to-teal-900/30',      iconColor:'text-cyan-400'   },
      { id:3,  title:'3D Icon Pack — 800 icônes', category:'ILLUSTRATION',categoryColor:'amber',  price:39,  oldPrice:59,  rating:5.0, reviews:87,  badge:'⭐ Top rated',  badgeColor:'amber',  icon:'palette',    gradient:'from-amber-600/30 to-orange-900/30',   iconColor:'text-amber-400'  },
      { id:4,  title:'SFX Pack Vol.3 — UI Sounds',category:'AUDIO',       categoryColor:'rose',   price:19,  oldPrice:null, rating:4.7, reviews:54,  badge:null,          badgeColor:null,     icon:'music',      gradient:'from-rose-600/30 to-pink-900/30',      iconColor:'text-rose-400'   },
      { id:5,  title:'Landing Page Starter Kit',  category:'TEMPLATE',    categoryColor:'emerald',price:0,   oldPrice:null, rating:4.6, reviews:234, badge:'Gratuit',     badgeColor:'emerald',icon:'code',       gradient:'from-emerald-600/30 to-green-900/30', iconColor:'text-emerald-400'},
      { id:6,  title:'Motion UI Library — Framer',category:'PLUGIN',      categoryColor:'sky',    price:29,  oldPrice:49,  rating:4.9, reviews:143, badge:'Promo -40%',   badgeColor:'sky',    icon:'bolt',       gradient:'from-sky-600/30 to-blue-900/30',       iconColor:'text-sky-400'    },
      { id:7,  title:'Design System Complet 2024',category:'BUNDLE',      categoryColor:'indigo', price:99,  oldPrice:199, rating:5.0, reviews:67,  badge:null,          badgeColor:null,     icon:'layers',     gradient:'from-indigo-600/30 to-indigo-900/30',  iconColor:'text-indigo-400' },
      { id:8,  title:'After Effects Intro Pack',  category:'VIDÉO',       categoryColor:'fuchsia',price:34,  oldPrice:null, rating:4.5, reviews:89,  badge:'Tendance',    badgeColor:'fuchsia',icon:'video',      gradient:'from-fuchsia-600/30 to-fuchsia-900/30',iconColor:'text-fuchsia-400'},
      { id:9,  title:'Framer Components Pro',     category:'UI KIT',      categoryColor:'violet', price:59,  oldPrice:89,  rating:4.8, reviews:176, badge:'Nouveau',     badgeColor:'violet', icon:'dashboard',  gradient:'from-violet-600/30 to-purple-900/30',  iconColor:'text-violet-400' },
      { id:10, title:'TypeScript Masterclass',    category:'COURS',       categoryColor:'cyan',   price:89,  oldPrice:null, rating:4.9, reviews:305, badge:null,          badgeColor:null,     icon:'book',       gradient:'from-cyan-600/30 to-teal-900/30',      iconColor:'text-cyan-400'   },
      { id:11, title:'Webflow Starter Templates', category:'TEMPLATE',    categoryColor:'emerald',price:49,  oldPrice:79,  rating:4.7, reviews:112, badge:null,          badgeColor:null,     icon:'code',       gradient:'from-emerald-600/30 to-green-900/30', iconColor:'text-emerald-400'},
      { id:12, title:'Brand Identity Kit 2024',   category:'ILLUSTRATION',categoryColor:'amber',  price:69,  oldPrice:119, rating:4.8, reviews:58,  badge:'Promo -42%',  badgeColor:'amber',  icon:'palette',    gradient:'from-amber-600/30 to-orange-900/30',   iconColor:'text-amber-400'  },
    ];

    /* ===================== ICONS SVG ===================== */
    const icons = {
      dashboard: `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"/>`,
      book:      `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>`,
      palette:   `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>`,
      music:     `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>`,
      code:      `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>`,
      bolt:      `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"/>`,
      layers:    `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>`,
      video:     `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10l4.553-2.069A1 1 0 0121 8.867v6.266a1 1 0 01-1.447.902L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>`,
    };

    /* ===================== RENDER GRID ===================== */
    let currentView = 'grid';
    let cartCount = 0;

    function buildStars(r) {
      const full = Math.floor(r);
      const half = r % 1 >= 0.5;
      let s = '';
      for (let i=0;i<5;i++) s += i<full ? '★' : (i===full&&half ? '★' : '☆');
      return s;
    }

    function badgeClass(color) {
      const map = {violet:'bg-violet-500/90',cyan:'bg-cyan-500/90',amber:'bg-amber-500/90',rose:'bg-rose-500/90',emerald:'bg-emerald-500/90',sky:'bg-sky-500/90',indigo:'bg-indigo-500/90',fuchsia:'bg-fuchsia-500/90'};
      return map[color] || 'bg-violet-500/90';
    }
    function catColorClass(color) {
      const map = {violet:'text-violet-400',cyan:'text-cyan-400',amber:'text-amber-400',rose:'text-rose-400',emerald:'text-emerald-400',sky:'text-sky-400',indigo:'text-indigo-400',fuchsia:'text-fuchsia-400'};
      return map[color] || 'text-violet-400';
    }

    function renderGrid(data) {
      const grid = document.getElementById('productsGrid');
      if (currentView === 'grid') {
        grid.className = 'grid sm:grid-cols-2 xl:grid-cols-3 gap-4 mb-8';
        grid.innerHTML = data.map((p, i) => `
          <div class="product-card" style="animation: cardIn 0.5s ease ${i*0.06}s both;">
            <div class="card-img bg-gradient-to-br ${p.gradient}">
              ${p.badge ? `<div class="absolute top-3 left-3 ${badgeClass(p.badgeColor)} text-white text-xs px-2 py-1 rounded-lg font-medium backdrop-blur">${p.badge}</div>` : ''}
              <button class="wishlist-btn" onclick="toggleWishlist(this, event)">
                <svg class="w-3.5 h-3.5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
              </button>
              <svg class="w-12 h-12 ${p.iconColor}" fill="none" stroke="currentColor" viewBox="0 0 24 24">${icons[p.icon]}</svg>
              <button class="preview-btn" onclick="openModal(${p.id}, event)">Aperçu rapide ✦</button>
            </div>
            <div class="p-4">
              <div class="text-xs font-medium ${catColorClass(p.categoryColor)} mb-1">${p.category}</div>
              <h3 class="font-display text-white font-600 text-sm mb-1.5 leading-snug">${p.title}</h3>
              <div class="flex items-center gap-1 text-xs text-slate-500 mb-3">
                <span class="stars text-xs">${buildStars(p.rating)}</span>
                <span>${p.rating} (${p.reviews})</span>
              </div>
              <div class="flex items-center justify-between">
                <div>
                  <span class="text-white font-700 text-lg">${p.price === 0 ? '<span class="text-emerald-400">Gratuit</span>' : p.price + '€'}</span>
                  ${p.oldPrice ? `<span class="text-slate-600 text-xs line-through ml-1">${p.oldPrice}€</span>` : ''}
                </div>
                <button class="btn-primary text-white text-xs px-3 py-1.5 rounded-lg font-medium" onclick="addToCart('${p.title}')">
                  ${p.price === 0 ? 'Obtenir' : 'Acheter'}
                </button>
              </div>
            </div>
          </div>
        `).join('');
      } else {
        grid.className = 'flex flex-col gap-3 mb-8';
        grid.innerHTML = data.map((p, i) => `
          <div class="product-card-list" style="animation: cardIn 0.4s ease ${i*0.04}s both;">
            <div class="w-32 flex-shrink-0 bg-gradient-to-br ${p.gradient} flex items-center justify-center">
              <svg class="w-8 h-8 ${p.iconColor}" fill="none" stroke="currentColor" viewBox="0 0 24 24">${icons[p.icon]}</svg>
            </div>
            <div class="flex-1 p-4 flex flex-col sm:flex-row sm:items-center gap-3">
              <div class="flex-1">
                <div class="text-xs font-medium ${catColorClass(p.categoryColor)} mb-0.5">${p.category}</div>
                <h3 class="font-display text-white font-600 text-sm mb-1">${p.title}</h3>
                <div class="flex items-center gap-1 text-xs text-slate-500">
                  <span class="stars text-xs">${buildStars(p.rating)}</span>
                  <span>${p.rating} (${p.reviews})</span>
                </div>
              </div>
              <div class="flex items-center gap-4 flex-shrink-0">
                <div>
                  <span class="text-white font-700">${p.price === 0 ? '<span class="text-emerald-400">Gratuit</span>' : p.price + '€'}</span>
                  ${p.oldPrice ? `<span class="text-slate-600 text-xs line-through ml-1">${p.oldPrice}€</span>` : ''}
                </div>
                <button class="btn-primary text-white text-xs px-3 py-1.5 rounded-lg font-medium" onclick="addToCart('${p.title}')">
                  ${p.price === 0 ? 'Obtenir' : 'Acheter'}
                </button>
              </div>
            </div>
          </div>
        `).join('');
      }

      // Re-attach cursor effects
      document.querySelectorAll('.product-card, .product-card-list, button, a').forEach(el => {
        el.addEventListener('mouseenter', () => { cursor.style.width='20px'; cursor.style.height='20px'; });
        el.addEventListener('mouseleave', () => { cursor.style.width='12px'; cursor.style.height='12px'; });
      });
    }

    renderGrid(products);

    /* ===================== VIEW TOGGLE ===================== */
    function setView(v) {
      currentView = v;
      document.getElementById('gridBtn').classList.toggle('active', v==='grid');
      document.getElementById('listBtn').classList.toggle('active', v==='list');
      renderGrid(products);
    }

    /* ===================== SORT ===================== */
    function sortProducts(val) {
      let sorted = [...products];
      if (val==='price-asc')  sorted.sort((a,b) => a.price - b.price);
      if (val==='price-desc') sorted.sort((a,b) => b.price - a.price);
      if (val==='rating')     sorted.sort((a,b) => b.rating - a.rating);
      if (val==='newest')     sorted.reverse();
      renderGrid(sorted);
    }

    /* ===================== CART ===================== */
    function addToCart(name) {
      cartCount++;
      const badge = document.getElementById('cartCount');
      badge.textContent = cartCount;
      badge.style.display = 'flex';
      badge.style.animation = 'none';
      setTimeout(() => badge.style.animation = '', 10);

      const toast = document.getElementById('toast');
      document.getElementById('toastMsg').textContent = (name ? name : 'Produit') + ' ajouté !';
      toast.classList.add('show');
      setTimeout(() => toast.classList.remove('show'), 3000);
    }

    /* ===================== WISHLIST ===================== */
    function toggleWishlist(btn, e) {
      e.stopPropagation();
      btn.classList.toggle('active');
      const name = btn.closest('.product-card')?.querySelector('.font-display')?.textContent || 'Produit';
      const isAdded = btn.classList.contains('active');
      const toast = document.getElementById('toast');
      document.getElementById('toastMsg').textContent = isAdded ? '❤️ Ajouté aux favoris !' : '💔 Retiré des favoris';
      toast.classList.add('show');
      setTimeout(() => toast.classList.remove('show'), 2500);
    }

    /* ===================== MODAL ===================== */
    function openModal(id, e) {
      if (e) e.stopPropagation();
      const p = products.find(x => x.id === id);
      if (!p) return;
      document.getElementById('modalTitle').textContent    = p.title;
      document.getElementById('modalCategory').textContent = p.category;
      document.getElementById('modalCategory').className   = 'text-xs font-medium mb-1 ' + catColorClass(p.categoryColor);
      document.getElementById('modalRating').textContent   = `${p.rating} • ${p.reviews} avis`;
      document.getElementById('modalPrice').textContent    = p.price === 0 ? 'Gratuit' : p.price + '€';
      document.getElementById('modalOldPrice').textContent = p.oldPrice ? p.oldPrice + '€' : '';
      document.getElementById('modalPreviewBg').className  = `h-48 rounded-xl mb-6 flex items-center justify-center bg-gradient-to-br ${p.gradient}`;
      document.getElementById('modalIcon').className       = `w-16 h-16 ${p.iconColor}`;
      document.getElementById('modalIcon').innerHTML       = icons[p.icon];
      document.getElementById('modal').classList.add('open');
    }

    function closeModal() {
      document.getElementById('modal').classList.remove('open');
    }
    document.getElementById('modal').addEventListener('click', e => {
      if (e.target === document.getElementById('modal')) closeModal();
    });
    document.addEventListener('keydown', e => { if (e.key==='Escape') closeModal(); });

    /* ===================== PRICE RANGE ===================== */
    function updatePrice(input) {
      const val = input.value;
      const pct = (val / 300 * 100).toFixed(0);
      input.style.setProperty('--val', pct + '%');
      document.getElementById('priceLabel').textContent = `0€ — ${val}€`;
    }
    // Init
    const pr = document.getElementById('priceRange');
    pr.style.setProperty('--val', '50%');

    /* ===================== FILTERS ===================== */
    function removeFilter(el) {
      el.style.transform = 'scale(0)';
      el.style.opacity = '0';
      el.style.transition = 'all 0.2s';
      setTimeout(() => el.remove(), 200);
    }
    function clearFilters() {
      document.querySelectorAll('.filter-tag').forEach(t => removeFilter(t));
    }

    /* ===================== PAGINATION ===================== */
    function changePage(btn) {
      document.querySelectorAll('.page-btn').forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      window.scrollTo({ top: 300, behavior: 'smooth' });
      // Simulate new data loading
      const grid = document.getElementById('productsGrid');
      grid.style.opacity = '0';
      grid.style.transform = 'translateY(10px)';
      grid.style.transition = 'all 0.3s';
      setTimeout(() => {
        renderGrid([...products].sort(() => Math.random() - 0.5));
        grid.style.opacity = '1';
        grid.style.transform = 'translateY(0)';
      }, 300);
    }

    /* ===================== CATEGORY PILLS ===================== */
    document.querySelectorAll('.cat-pill').forEach(pill => {
      pill.addEventListener('click', () => {
        pill.closest('div').querySelectorAll('.cat-pill').forEach(p => p.classList.remove('active'));
        pill.classList.add('active');
      });
    });

    /* ===================== SEARCH ===================== */
    document.getElementById('navSearch').addEventListener('input', function() {
      const q = this.value.toLowerCase();
      const filtered = q ? products.filter(p => p.title.toLowerCase().includes(q) || p.category.toLowerCase().includes(q)) : products;
      document.getElementById('resultCount').textContent = filtered.length.toLocaleString();
      renderGrid(filtered);
    });

    /* ===================== SCROLL ANIM ===================== */
    const observer = new IntersectionObserver(entries => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.style.animation = 'fadeUp 0.5s ease forwards';
          observer.unobserve(entry.target);
        }
      });
    }, { threshold: 0.05 });

    // Observe sidebar sections
    document.querySelectorAll('.filter-section').forEach((el, i) => {
      el.style.opacity = '0';
      el.style.animationDelay = (i * 0.08) + 's';
      observer.observe(el);
    });
  </script>
</body>
</html>
