<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>PixelVault — Créateurs</title>
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

    /* ── Cursor ── */
    .cursor {
      width: 12px; height: 12px;
      background: var(--c-accent2);
      border-radius: 50%;
      position: fixed; pointer-events: none; z-index: 9999;
      transform: translate(-50%, -50%);
      transition: width .2s, height .2s, background .2s;
      mix-blend-mode: screen;
    }
    .cursor-ring {
      width: 36px; height: 36px;
      border: 1.5px solid rgba(124,58,237,.5);
      border-radius: 50%;
      position: fixed; pointer-events: none; z-index: 9998;
      transform: translate(-50%, -50%);
      transition: width .3s, height .3s;
    }

    h1,h2,h3,h4,.font-display { font-family: 'Syne', sans-serif; }

    /* ── Noise ── */
    body::before {
      content: '';
      position: fixed; inset: 0;
      background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.03'/%3E%3C/svg%3E");
      pointer-events: none; z-index: 1000; opacity: .4;
    }

    /* ── Grid bg ── */
    .grid-bg {
      background-image:
        linear-gradient(rgba(124,58,237,.04) 1px, transparent 1px),
        linear-gradient(90deg, rgba(124,58,237,.04) 1px, transparent 1px);
      background-size: 60px 60px;
    }

    .orb { position: absolute; border-radius: 50%; filter: blur(80px); pointer-events: none; }

    /* ── Animations ── */
    @keyframes fadeUp   { from{opacity:0;transform:translateY(24px)} to{opacity:1;transform:translateY(0)} }
    @keyframes fadeIn   { from{opacity:0} to{opacity:1} }
    @keyframes shimmer  { 0%{background-position:-200% 0} 100%{background-position:200% 0} }
    @keyframes spinSlow { from{transform:rotate(0deg)} to{transform:rotate(360deg)} }
    @keyframes pulseRing{ 0%{transform:scale(1);opacity:.6} 100%{transform:scale(1.8);opacity:0} }
    @keyframes cardIn   { from{opacity:0;transform:translateY(20px) scale(.97)} to{opacity:1;transform:translateY(0) scale(1)} }
    @keyframes float    { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-10px)} }
    @keyframes ticker   { from{transform:translateX(0)} to{transform:translateX(-50%)} }
    @keyframes countUp  { from{opacity:0;transform:translateY(8px)} to{opacity:1;transform:translateY(0)} }
    @keyframes avatarPop{ 0%{transform:scale(0.8);opacity:0} 60%{transform:scale(1.06)} 100%{transform:scale(1);opacity:1} }
    @keyframes borderGlow {
      0%,100%{box-shadow:0 0 0 0 rgba(124,58,237,0)}
      50%{box-shadow:0 0 20px 4px rgba(124,58,237,.3)}
    }
    @keyframes badgePop {
      0%{transform:scale(0) rotate(-10deg);opacity:0}
      60%{transform:scale(1.1) rotate(3deg)}
      100%{transform:scale(1) rotate(0deg);opacity:1}
    }

    .anim-fade-up { animation: fadeUp .6s ease forwards; }
    .delay-1 { animation-delay:.08s; opacity:0; }
    .delay-2 { animation-delay:.18s; opacity:0; }
    .delay-3 { animation-delay:.28s; opacity:0; }
    .delay-4 { animation-delay:.38s; opacity:0; }
    .delay-5 { animation-delay:.50s; opacity:0; }

    /* ── Nav ── */
    nav { backdrop-filter:blur(16px); -webkit-backdrop-filter:blur(16px); }

    /* ── Grad text ── */
    .grad-text {
      background: linear-gradient(135deg,#a78bfa 0%,#22d3ee 50%,#f59e0b 100%);
      -webkit-background-clip:text; -webkit-text-fill-color:transparent;
    }

    /* ── Scrollbar ── */
    ::-webkit-scrollbar { width:5px; }
    ::-webkit-scrollbar-track { background:var(--c-bg); }
    ::-webkit-scrollbar-thumb { background:rgba(124,58,237,.4); border-radius:3px; }

    /* ── Stars ── */
    .stars { color:var(--c-gold); }

    /* ── Buttons ── */
    .btn-primary {
      background:linear-gradient(135deg,#7c3aed,#5b21b6);
      position:relative; overflow:hidden;
      transition:transform .2s, box-shadow .2s;
    }
    .btn-primary::after {
      content:'';
      position:absolute; inset:0;
      background:linear-gradient(105deg,transparent 40%,rgba(255,255,255,.15) 50%,transparent 60%);
      background-size:200% 100%;
      animation:shimmer 2.5s infinite;
    }
    .btn-primary:hover { transform:translateY(-2px); box-shadow:0 0 30px rgba(124,58,237,.5); }

    .btn-outline {
      border:1px solid rgba(124,58,237,.4);
      transition:all .2s; background:transparent;
    }
    .btn-outline:hover {
      border-color:var(--c-accent2);
      background:rgba(6,182,212,.08);
      box-shadow:0 0 20px rgba(6,182,212,.15);
    }

    /* ── Search ── */
    .search-bar {
      background:rgba(255,255,255,.04);
      border:1px solid var(--c-border);
      border-radius:12px;
      transition:border-color .2s, box-shadow .2s;
    }
    .search-bar:focus-within {
      border-color:rgba(124,58,237,.5);
      box-shadow:0 0 0 3px rgba(124,58,237,.08);
    }
    .search-input {
      background:transparent; border:none; outline:none;
      color:var(--c-text); font-family:'DM Sans',sans-serif; font-size:14px; width:100%;
    }
    .search-input::placeholder { color:#64748b; }

    /* ── Cat pills ── */
    .cat-pill {
      border:1px solid var(--c-border);
      transition:all .2s; cursor:pointer; white-space:nowrap;
    }
    .cat-pill:hover, .cat-pill.active {
      border-color:var(--c-accent);
      background:rgba(124,58,237,.15);
      color:#a78bfa;
    }

    /* ── Sort select ── */
    .sort-select {
      background:transparent;
      border:1px solid var(--c-border);
      color:var(--c-text); border-radius:10px;
      padding:8px 12px; font-size:13px;
      font-family:'DM Sans',sans-serif;
      cursor:pointer; outline:none; transition:border-color .2s;
    }
    .sort-select:hover, .sort-select:focus { border-color:rgba(124,58,237,.5); }
    .sort-select option { background:#111118; }

    /* ── Creator Card ── */
    .creator-card {
      background:var(--c-surface);
      border:1px solid var(--c-border);
      border-radius:20px;
      overflow:hidden;
      transition:transform .3s ease, border-color .3s, box-shadow .3s;
      position:relative;
      cursor:pointer;
    }
    .creator-card::before {
      content:'';
      position:absolute; inset:0;
      background:linear-gradient(135deg,rgba(124,58,237,.06),rgba(6,182,212,.03));
      opacity:0; transition:opacity .3s; pointer-events:none;
    }
    .creator-card:hover { transform:translateY(-6px); border-color:rgba(124,58,237,.4); box-shadow:0 20px 60px rgba(124,58,237,.15); }
    .creator-card:hover::before { opacity:1; }

    /* cover banner */
    .creator-cover {
      height:100px;
      position:relative; overflow:hidden;
    }
    .creator-cover::after {
      content:'';
      position:absolute; inset:0;
      background:linear-gradient(to bottom,transparent 40%,var(--c-surface));
    }

    /* avatar */
    .creator-avatar {
      width:68px; height:68px;
      border-radius:50%;
      border:3px solid var(--c-surface);
      position:relative; z-index:2;
      font-family:'Syne',sans-serif; font-weight:800;
      font-size:22px;
      display:flex; align-items:center; justify-content:center;
      flex-shrink:0;
      animation:avatarPop .5s ease forwards;
    }

    /* verified badge */
    .verified-badge {
      position:absolute; bottom:-2px; right:-2px;
      width:20px; height:20px;
      background:linear-gradient(135deg,#7c3aed,#06b6d4);
      border-radius:50%;
      border:2px solid var(--c-surface);
      display:flex; align-items:center; justify-content:center;
    }

    /* follow btn */
    .follow-btn {
      border:1px solid rgba(124,58,237,.4);
      border-radius:8px;
      color:#a78bfa; font-size:12px; font-weight:500;
      padding:5px 14px;
      transition:all .2s; background:transparent;
      cursor:pointer;
    }
    .follow-btn:hover, .follow-btn.following {
      background:rgba(124,58,237,.2);
      border-color:var(--c-accent);
    }
    .follow-btn.following { color:#22d3ee; border-color:rgba(6,182,212,.4); background:rgba(6,182,212,.08); }

    /* mini product strip */
    .mini-product {
      width:48px; height:48px;
      border-radius:10px;
      display:flex; align-items:center; justify-content:center;
      border:1px solid var(--c-border);
      transition:transform .2s, border-color .2s;
      flex-shrink:0;
    }
    .mini-product:hover { transform:scale(1.1); border-color:rgba(124,58,237,.4); }

    /* ── Featured / Spotlight card ── */
    .spotlight-card {
      background:var(--c-surface);
      border:1px solid rgba(124,58,237,.25);
      border-radius:24px;
      position:relative; overflow:hidden;
    }
    .spotlight-card::before {
      content:'';
      position:absolute; inset:0;
      background:linear-gradient(135deg,rgba(124,58,237,.1),rgba(6,182,212,.05),transparent);
      pointer-events:none;
    }

    /* ── Stat card ── */
    .stat-card {
      background:var(--c-surface);
      border:1px solid var(--c-border);
      border-radius:16px;
      transition:border-color .3s;
    }
    .stat-card:hover { border-color:rgba(124,58,237,.3); }

    /* ── Rank badge ── */
    .rank-num {
      font-family:'Syne',sans-serif; font-weight:800;
      font-size:11px;
      width:22px; height:22px;
      border-radius:6px;
      display:flex; align-items:center; justify-content:center;
    }
    .rank-1 { background:linear-gradient(135deg,#f59e0b,#fbbf24); color:#000; }
    .rank-2 { background:linear-gradient(135deg,#94a3b8,#cbd5e1); color:#000; }
    .rank-3 { background:linear-gradient(135deg,#b45309,#d97706); color:#fff; }
    .rank-other { background:rgba(255,255,255,.06); color:#64748b; }

    /* ── Progress bar ── */
    .prog-track {
      height:3px; border-radius:2px;
      background:var(--c-border); overflow:hidden;
    }
    .prog-fill {
      height:100%; border-radius:2px;
      background:linear-gradient(90deg,var(--c-accent),var(--c-accent2));
      transition:width 1.2s cubic-bezier(.22,1,.36,1);
    }

    /* ── Leaderboard row ── */
    .lb-row {
      display:flex; align-items:center; gap:12px;
      padding:10px 14px; border-radius:12px;
      border:1px solid transparent;
      transition:all .2s; cursor:pointer;
    }
    .lb-row:hover { background:rgba(124,58,237,.07); border-color:rgba(124,58,237,.15); }
    .lb-row.top { background:rgba(245,158,11,.06); border-color:rgba(245,158,11,.2); }

    /* ── Pagination ── */
    .page-btn {
      width:36px; height:36px;
      border-radius:9px; border:1px solid var(--c-border);
      display:flex; align-items:center; justify-content:center;
      cursor:pointer; transition:all .2s;
      color:#64748b; font-size:13px; font-weight:500;
      font-family:'Syne',sans-serif;
    }
    .page-btn:hover { border-color:rgba(124,58,237,.4); color:#a78bfa; background:rgba(124,58,237,.08); }
    .page-btn.active { background:var(--c-accent); border-color:var(--c-accent); color:#fff; box-shadow:0 0 16px rgba(124,58,237,.4); }

    /* ── Modal ── */
    .modal-overlay {
      position:fixed; inset:0; z-index:200;
      background:rgba(0,0,0,.85);
      backdrop-filter:blur(10px);
      display:flex; align-items:center; justify-content:center;
      opacity:0; pointer-events:none; transition:opacity .3s;
    }
    .modal-overlay.open { opacity:1; pointer-events:all; }
    .modal-box {
      background:#0e0e18;
      border:1px solid rgba(124,58,237,.3);
      border-radius:28px;
      max-width:720px; width:94%;
      transform:scale(.95) translateY(20px);
      transition:transform .35s cubic-bezier(.22,1,.36,1);
      max-height:90vh; overflow-y:auto;
    }
    .modal-overlay.open .modal-box { transform:scale(1) translateY(0); }

    /* ── Toast ── */
    .toast {
      position:fixed; bottom:24px; right:24px; z-index:300;
      background:var(--c-surface);
      border:1px solid rgba(124,58,237,.4);
      border-radius:14px; padding:12px 18px;
      display:flex; align-items:center; gap:12px;
      transform:translateY(80px); opacity:0;
      transition:all .4s cubic-bezier(.34,1.56,.64,1);
      box-shadow:0 8px 32px rgba(0,0,0,.4);
      pointer-events:none;
    }
    .toast.show { transform:translateY(0); opacity:1; }

    /* ── Ticker ── */
    .ticker-wrap { overflow:hidden; }
    .ticker-track { display:flex; animation:ticker 28s linear infinite; white-space:nowrap; }
    .ticker-track:hover { animation-play-state:paused; }

    /* ── Spotlight animated border ── */
    .glow-border { animation:borderGlow 3s ease-in-out infinite; }

    /* ── View toggle ── */
    .view-btn {
      width:34px; height:34px; border-radius:8px;
      border:1px solid var(--c-border);
      display:flex; align-items:center; justify-content:center;
      cursor:pointer; transition:all .2s; color:#64748b;
    }
    .view-btn.active, .view-btn:hover {
      background:rgba(124,58,237,.15);
      border-color:rgba(124,58,237,.4); color:#a78bfa;
    }

    /* ── Become creator CTA ── */
    .become-card {
      background:linear-gradient(135deg,rgba(124,58,237,.15),rgba(6,182,212,.08));
      border:1px solid rgba(124,58,237,.25);
      border-radius:20px; position:relative; overflow:hidden;
    }
  </style>
</head>
<body class="grid-bg">

<!-- ── Cursor ── -->
<div class="cursor" id="cursor"></div>
<div class="cursor-ring" id="cursorRing"></div>

<!-- ── Toast ── -->
<div class="toast" id="toast">
  <div class="w-8 h-8 rounded-full bg-linear-to-br from-emerald-400 to-cyan-500 flex items-center justify-center shrink-0">
    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
  </div>
  <div>
    <div class="text-white text-sm font-medium" id="toastMsg">Action effectuée !</div>
    <div class="text-slate-500 text-xs" id="toastSub">PixelVault</div>
  </div>
</div>

<!-- ── Creator Profile Modal ── -->
<div class="modal-overlay" id="modal">
  <div class="modal-box">
    <div class="p-6 md:p-8">
      <!-- Modal header -->
      <div class="flex items-start justify-between mb-6">
        <div class="flex items-center gap-4">
          <div class="creator-avatar w-16 h-16 text-xl" id="mAvatar" style="background:linear-gradient(135deg,#7c3aed,#22d3ee)">S</div>
          <div>
            <div class="flex items-center gap-2">
              <h2 class="font-display text-xl font-700 text-white" id="mName">Sophie Martin</h2>
              <svg class="w-4 h-4 text-cyan-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            </div>
            <div class="text-slate-400 text-sm" id="mSpeciality">UI/UX Designer & Illustratrice</div>
            <div class="flex items-center gap-2 mt-1">
              <div class="stars text-xs" id="mStars">★★★★★</div>
              <span class="text-slate-500 text-xs" id="mRating">4.9 • 312 avis</span>
            </div>
          </div>
        </div>
        <button onclick="closeModal()" class="w-8 h-8 rounded-lg border border-white/10 flex items-center justify-center text-slate-400 hover:text-white hover:border-white/30 transition-all shrink-0">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
      </div>

      <!-- Stats row -->
      <div class="grid grid-cols-4 gap-3 mb-6">
        <div class="bg-white/3 rounded-xl p-3 text-center border border-white/5">
          <div class="font-display text-white font-700 text-xl" id="mProducts">48</div>
          <div class="text-slate-500 text-xs mt-0.5">Produits</div>
        </div>
        <div class="bg-white/3 rounded-xl p-3 text-center border border-white/5">
          <div class="font-display text-white font-700 text-xl" id="mSales">2.1k</div>
          <div class="text-slate-500 text-xs mt-0.5">Ventes</div>
        </div>
        <div class="bg-white/3 rounded-xl p-3 text-center border border-white/5">
          <div class="font-display text-white font-700 text-xl" id="mFollowers">8.4k</div>
          <div class="text-slate-500 text-xs mt-0.5">Abonnés</div>
        </div>
        <div class="bg-white/3 rounded-xl p-3 text-center border border-white/5">
          <div class="font-display text-white font-700 text-xl" id="mYears">3 ans</div>
          <div class="text-slate-500 text-xs mt-0.5">Ancienneté</div>
        </div>
      </div>

      <!-- Bio -->
      <p class="text-slate-400 text-sm leading-relaxed mb-5" id="mBio">
        Designer passionnée spécialisée dans la création d'interfaces utilisateur élégantes et de kits d'icônes 3D. Mes produits sont utilisés par plus de 2 000 équipes dans le monde. Je m'efforce toujours de livrer des ressources de qualité professionnelle avec une documentation complète.
      </p>

      <!-- Tags spécialités -->
      <div class="flex flex-wrap gap-2 mb-6" id="mTags">
        <span class="text-xs px-3 py-1 rounded-full border border-violet-500/30 text-violet-400 bg-violet-500/10">Figma</span>
        <span class="text-xs px-3 py-1 rounded-full border border-cyan-500/30 text-cyan-400 bg-cyan-500/10">UI Design</span>
        <span class="text-xs px-3 py-1 rounded-full border border-amber-500/30 text-amber-400 bg-amber-500/10">Illustrations</span>
        <span class="text-xs px-3 py-1 rounded-full border border-white/10 text-slate-400">Dark Mode</span>
        <span class="text-xs px-3 py-1 rounded-full border border-white/10 text-slate-400">3D Icons</span>
      </div>

      <!-- Top produits -->
      <div class="mb-6">
        <div class="font-display text-white text-sm font-600 mb-3">Produits populaires</div>
        <div class="space-y-2" id="mProductsList">
          <div class="flex items-center gap-3 p-3 rounded-xl bg-white/3 border border-white/5 hover:border-violet-500/20 transition-all">
            <div class="w-10 h-10 rounded-lg bg-linear-to-br from-violet-600/40 to-purple-900/40 flex items-center justify-center shrink-0">
              <svg class="w-5 h-5 text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5z"/></svg>
            </div>
            <div class="flex-1">
              <div class="text-white text-sm font-medium">SaaS Dashboard Pro</div>
              <div class="text-slate-500 text-xs">★★★★★ 4.9 • 312 ventes</div>
            </div>
            <div class="text-white font-700 text-sm">49€</div>
          </div>
          <div class="flex items-center gap-3 p-3 rounded-xl bg-white/3 border border-white/5 hover:border-violet-500/20 transition-all">
            <div class="w-10 h-10 rounded-lg bg-linear-to-br from-amber-600/40 to-orange-900/40 flex items-center justify-center shrink-0">
              <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4z"/></svg>
            </div>
            <div class="flex-1">
              <div class="text-white text-sm font-medium">3D Icon Pack — 800 icônes</div>
              <div class="text-slate-500 text-xs">★★★★★ 5.0 • 87 ventes</div>
            </div>
            <div class="text-white font-700 text-sm">39€</div>
          </div>
          <div class="flex items-center gap-3 p-3 rounded-xl bg-white/3 border border-white/5 hover:border-violet-500/20 transition-all">
            <div class="w-10 h-10 rounded-lg bg-linear-to-br from-cyan-600/40 to-teal-900/40 flex items-center justify-center shrink-0">
              <svg class="w-5 h-5 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>
            </div>
            <div class="flex-1">
              <div class="text-white text-sm font-medium">Framer Landing Templates</div>
              <div class="text-slate-500 text-xs">★★★★☆ 4.7 • 143 ventes</div>
            </div>
            <div class="text-white font-700 text-sm">59€</div>
          </div>
        </div>
      </div>

      <!-- CTA -->
      <div class="flex gap-3">
        <button class="btn-primary text-white px-6 py-3 rounded-xl font-medium text-sm flex-1 flex items-center justify-center gap-2" onclick="showToast('Suivi activé ! 🎉','Vous suivez maintenant ce créateur'); closeModal()">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
          Suivre ce créateur
        </button>
        <a href="explorer.html" class="btn-outline text-slate-300 px-6 py-3 rounded-xl font-medium text-sm flex items-center gap-2 justify-center">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
          Voir ses produits
        </a>
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
        <input class="search-input" type="text" placeholder="Rechercher un créateur..." id="navSearch"/>
      </div>
    </div>

    <div class="hidden md:flex items-center gap-8 text-sm text-slate-400">
      <a href="/" class="hover:text-white transition-colors">Accueil</a>
      <a href="/explorer" class="hover:text-white transition-colors">Explorer</a>
      <a href="/createurs" class="text-violet-400 font-medium">Créateurs</a>
    </div>

    <div class="flex items-center gap-3">
      <button class="relative w-9 h-9 rounded-lg border border-white/10 flex items-center justify-center text-slate-400 hover:text-white hover:border-white/20 transition-all">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
      </button>
      <button class="btn-primary text-white text-sm px-5 py-2 rounded-lg font-medium">Devenir créateur</button>
    </div>
  </div>
</nav>

<!-- ===== PAGE HEADER ===== -->
<div class="relative pt-16 overflow-hidden">
  <div class="orb" style="width:500px;height:300px;background:rgba(124,58,237,.12);top:-100px;left:-80px;"></div>
  <div class="orb" style="width:350px;height:350px;background:rgba(6,182,212,.08);top:0;right:0;"></div>
  <div class="orb" style="width:200px;height:200px;background:rgba(245,158,11,.06);bottom:-50px;left:40%;"></div>

  <div class="max-w-7xl mx-auto px-6 py-10 pb-6">
    <!-- Breadcrumb -->
    <div class="anim-fade-up delay-1 flex items-center gap-2 text-sm text-slate-500 mb-6">
      <a href="index.html" class="hover:text-slate-300 transition-colors">Accueil</a>
      <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
      <span class="text-violet-400">Créateurs</span>
    </div>

    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-8">
      <div>
        <h1 class="anim-fade-up delay-2 font-display text-4xl md:text-5xl font-800 text-white mb-3">
          Les <span class="grad-text">créateurs</span>
        </h1>
        <p class="anim-fade-up delay-3 text-slate-400">
          <span id="resultCount" class="text-white font-medium">847</span> créateurs de talent sur PixelVault
        </p>
      </div>
      <div class="anim-fade-up delay-4 flex gap-3">
        <button class="btn-primary text-white px-5 py-2.5 rounded-xl text-sm font-medium flex items-center gap-2" onclick="showToast('Bientôt disponible 🚀','La candidature créateur arrive !')">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
          Devenir créateur
        </button>
        <button class="btn-outline text-slate-300 px-5 py-2.5 rounded-xl text-sm font-medium">
          Comment ça marche ?
        </button>
      </div>
    </div>

    <!-- Filter pills -->
    <div class="anim-fade-up delay-5 flex gap-2 overflow-x-auto pb-2" style="scrollbar-width:none">
      <button class="cat-pill active text-sm px-4 py-2 rounded-full text-slate-400">Tous</button>
      <button class="cat-pill text-sm px-4 py-2 rounded-full text-slate-400">🎨 UI/UX Design</button>
      <button class="cat-pill text-sm px-4 py-2 rounded-full text-slate-400">💻 Développement</button>
      <button class="cat-pill text-sm px-4 py-2 rounded-full text-slate-400">📚 Formateurs</button>
      <button class="cat-pill text-sm px-4 py-2 rounded-full text-slate-400">🖼 Illustrateurs</button>
      <button class="cat-pill text-sm px-4 py-2 rounded-full text-slate-400">🎬 Motion</button>
      <button class="cat-pill text-sm px-4 py-2 rounded-full text-slate-400">🎵 Audio</button>
      <button class="cat-pill text-sm px-4 py-2 rounded-full text-slate-400">⭐ Top créateurs</button>
    </div>
  </div>
</div>

<!-- ===== STATS BANNER ===== -->
<div class="max-w-7xl mx-auto px-6 mb-8">
  <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
    <div class="stat-card p-5 flex items-center gap-4">
      <div class="w-10 h-10 rounded-xl bg-violet-500/15 flex items-center justify-center flex-shrink-0">
        <svg class="w-5 h-5 text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
      </div>
      <div>
        <div class="font-display text-white font-800 text-2xl">847</div>
        <div class="text-slate-500 text-xs">Créateurs actifs</div>
      </div>
    </div>
    <div class="stat-card p-5 flex items-center gap-4">
      <div class="w-10 h-10 rounded-xl bg-cyan-500/15 flex items-center justify-center flex-shrink-0">
        <svg class="w-5 h-5 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
      </div>
      <div>
        <div class="font-display text-white font-800 text-2xl">2.4k</div>
        <div class="text-slate-500 text-xs">Produits publiés</div>
      </div>
    </div>
    <div class="stat-card p-5 flex items-center gap-4">
      <div class="w-10 h-10 rounded-xl bg-amber-500/15 flex items-center justify-center flex-shrink-0">
        <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
      </div>
      <div>
        <div class="font-display text-white font-800 text-2xl">98k€</div>
        <div class="text-slate-500 text-xs">Reversé aux créateurs</div>
      </div>
    </div>
    <div class="stat-card p-5 flex items-center gap-4">
      <div class="w-10 h-10 rounded-xl bg-emerald-500/15 flex items-center justify-center flex-shrink-0">
        <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
      </div>
      <div>
        <div class="font-display text-white font-800 text-2xl">4.8</div>
        <div class="text-slate-500 text-xs">Note moyenne globale</div>
      </div>
    </div>
  </div>
</div>

<!-- ===== SPOTLIGHT — Créateur du mois ===== -->
<div class="max-w-7xl mx-auto px-6 mb-10">
  <div class="spotlight-card glow-border p-6 md:p-8">
    <div class="orb" style="width:300px;height:300px;background:rgba(124,58,237,.15);top:-80px;left:-80px;filter:blur(60px)"></div>
    <div class="orb" style="width:200px;height:200px;background:rgba(6,182,212,.1);bottom:-50px;right:-50px;filter:blur(50px)"></div>

    <div class="relative z-10 grid md:grid-cols-3 gap-8 items-center">
      <!-- Left: creator info -->
      <div class="md:col-span-2 flex flex-col sm:flex-row items-start sm:items-center gap-6">
        <div class="relative flex-shrink-0">
          <div class="creator-avatar w-20 h-20 text-2xl" style="background:linear-gradient(135deg,#7c3aed,#06b6d4);animation:avatarPop .6s ease forwards;">M</div>
          <div class="verified-badge">
            <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
          </div>
          <!-- Crown badge -->
          <div class="absolute -top-3 -right-3 w-8 h-8 rounded-full bg-gradient-to-br from-amber-400 to-amber-600 flex items-center justify-center text-sm" style="animation:badgePop .7s .3s ease both;">👑</div>
        </div>

        <div>
          <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-amber-500/10 border border-amber-500/30 text-amber-300 text-xs font-medium mb-3">
            <span class="relative flex h-2 w-2">
              <span style="animation:pulseRing 1.8s ease-out infinite;position:absolute;inset:0;border-radius:9999px;border:1px solid #f59e0b;"></span>
              <span class="h-2 w-2 rounded-full bg-amber-400"></span>
            </span>
            Créateur du mois — Février 2024
          </div>
          <h2 class="font-display text-white text-2xl md:text-3xl font-800 mb-1">Marcus Chen</h2>
          <p class="text-slate-400 text-sm mb-3">Senior Motion Designer & Développeur Front-end</p>
          <div class="flex flex-wrap gap-2 mb-4">
            <span class="text-xs px-3 py-1 rounded-full border border-violet-500/30 text-violet-400 bg-violet-500/10">Framer</span>
            <span class="text-xs px-3 py-1 rounded-full border border-cyan-500/30 text-cyan-400 bg-cyan-500/10">React</span>
            <span class="text-xs px-3 py-1 rounded-full border border-rose-500/30 text-rose-400 bg-rose-500/10">Motion</span>
            <span class="text-xs px-3 py-1 rounded-full border border-white/10 text-slate-400">GSAP</span>
          </div>
          <div class="flex items-center gap-6 text-sm">
            <div><span class="font-display text-white font-700 text-lg">76</span> <span class="text-slate-500 text-xs">produits</span></div>
            <div><span class="font-display text-white font-700 text-lg">5.2k</span> <span class="text-slate-500 text-xs">ventes</span></div>
            <div><span class="font-display text-white font-700 text-lg">14k</span> <span class="text-slate-500 text-xs">abonnés</span></div>
          </div>
        </div>
      </div>

      <!-- Right: quick stats + actions -->
      <div class="flex flex-col gap-4">
        <div class="bg-white/4 rounded-xl p-4 border border-white/5">
          <div class="flex items-center justify-between mb-3">
            <span class="text-slate-400 text-xs">Satisfaction clients</span>
            <span class="text-emerald-400 text-xs font-medium">+12% ce mois</span>
          </div>
          <div class="flex items-end gap-1 mb-2">
            <span class="font-display text-white text-3xl font-800">98%</span>
          </div>
          <div class="prog-track">
            <div class="prog-fill" style="width:98%;"></div>
          </div>
        </div>
        <div class="flex gap-3">
          <button class="btn-primary text-white px-5 py-2.5 rounded-xl text-sm font-medium flex-1 flex items-center gap-2 justify-center" onclick="openModal(0)">
            Voir le profil
          </button>
          <button class="follow-btn" onclick="toggleFollow(this)">+ Suivre</button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- ===== MAIN LAYOUT ===== -->
<div class="max-w-7xl mx-auto px-6 pb-24">
  <div class="flex gap-6">

    <!-- ===== SIDEBAR ===== -->
    <aside class="hidden lg:block w-72 flex-shrink-0">
      <div style="position:sticky;top:84px;">

        <!-- Leaderboard -->
        <div class="bg-[var(--c-surface)] border border-[var(--c-border)] rounded-20px p-5 mb-4" style="border-radius:20px;">
          <div class="flex items-center justify-between mb-4">
            <span class="font-display text-white text-sm font-700">🏆 Top Créateurs</span>
            <span class="text-xs text-violet-400">Ce mois-ci</span>
          </div>
          <div class="space-y-1" id="leaderboard"></div>
        </div>

        <!-- Filters -->
        <div class="bg-[var(--c-surface)] border border-[var(--c-border)] rounded-20px p-5 mb-4" style="border-radius:20px;">
          <div class="font-display text-white text-sm font-700 mb-4">Filtres</div>

          <!-- Specialties -->
          <div class="mb-4 pb-4 border-b border-[var(--c-border)]">
            <div class="text-slate-400 text-xs font-medium mb-3 uppercase tracking-wider">Spécialité</div>
            <div class="space-y-2">
              <label class="flex items-center gap-3 cursor-pointer group">
                <input type="checkbox" class="filter-checkbox" checked style="appearance:none;width:16px;height:16px;border:1.5px solid #3f3f5a;border-radius:4px;background:transparent;cursor:pointer;transition:all .2s;position:relative;flex-shrink:0;" />
                <span class="text-slate-400 text-sm group-hover:text-slate-200 transition-colors flex-1">UI/UX Design</span>
                <span class="text-xs text-slate-600 bg-white/5 px-2 py-0.5 rounded-full">234</span>
              </label>
              <label class="flex items-center gap-3 cursor-pointer group">
                <input type="checkbox" class="filter-checkbox" style="appearance:none;width:16px;height:16px;border:1.5px solid #3f3f5a;border-radius:4px;background:transparent;cursor:pointer;transition:all .2s;position:relative;flex-shrink:0;" />
                <span class="text-slate-400 text-sm group-hover:text-slate-200 transition-colors flex-1">Développement</span>
                <span class="text-xs text-slate-600 bg-white/5 px-2 py-0.5 rounded-full">187</span>
              </label>
              <label class="flex items-center gap-3 cursor-pointer group">
                <input type="checkbox" class="filter-checkbox" style="appearance:none;width:16px;height:16px;border:1.5px solid #3f3f5a;border-radius:4px;background:transparent;cursor:pointer;transition:all .2s;position:relative;flex-shrink:0;" />
                <span class="text-slate-400 text-sm group-hover:text-slate-200 transition-colors flex-1">Illustrations</span>
                <span class="text-xs text-slate-600 bg-white/5 px-2 py-0.5 rounded-full">98</span>
              </label>
              <label class="flex items-center gap-3 cursor-pointer group">
                <input type="checkbox" class="filter-checkbox" style="appearance:none;width:16px;height:16px;border:1.5px solid #3f3f5a;border-radius:4px;background:transparent;cursor:pointer;transition:all .2s;position:relative;flex-shrink:0;" />
                <span class="text-slate-400 text-sm group-hover:text-slate-200 transition-colors flex-1">Formation</span>
                <span class="text-xs text-slate-600 bg-white/5 px-2 py-0.5 rounded-full">112</span>
              </label>
              <label class="flex items-center gap-3 cursor-pointer group">
                <input type="checkbox" class="filter-checkbox" style="appearance:none;width:16px;height:16px;border:1.5px solid #3f3f5a;border-radius:4px;background:transparent;cursor:pointer;transition:all .2s;position:relative;flex-shrink:0;" />
                <span class="text-slate-400 text-sm group-hover:text-slate-200 transition-colors flex-1">Motion Design</span>
                <span class="text-xs text-slate-600 bg-white/5 px-2 py-0.5 rounded-full">76</span>
              </label>
            </div>
          </div>

          <!-- Rating filter -->
          <div class="mb-4 pb-4 border-b border-[var(--c-border)]">
            <div class="text-slate-400 text-xs font-medium mb-3 uppercase tracking-wider">Note minimale</div>
            <div class="space-y-2">
              <label class="flex items-center gap-3 cursor-pointer">
                <input type="radio" name="minRating" style="appearance:none;width:16px;height:16px;border:1.5px solid #3f3f5a;border-radius:50%;background:transparent;cursor:pointer;transition:all .2s;position:relative;flex-shrink:0;" checked/>
                <span class="stars text-sm">★★★★★</span><span class="text-slate-500 text-xs ml-1">5.0</span>
              </label>
              <label class="flex items-center gap-3 cursor-pointer">
                <input type="radio" name="minRating" style="appearance:none;width:16px;height:16px;border:1.5px solid #3f3f5a;border-radius:50%;background:transparent;cursor:pointer;transition:all .2s;position:relative;flex-shrink:0;" />
                <span class="stars text-sm">★★★★☆</span><span class="text-slate-500 text-xs ml-1">4.0+</span>
              </label>
              <label class="flex items-center gap-3 cursor-pointer">
                <input type="radio" name="minRating" style="appearance:none;width:16px;height:16px;border:1.5px solid #3f3f5a;border-radius:50%;background:transparent;cursor:pointer;transition:all .2s;position:relative;flex-shrink:0;" />
                <span class="stars text-sm">★★★☆☆</span><span class="text-slate-500 text-xs ml-1">3.0+</span>
              </label>
            </div>
          </div>

          <!-- Status -->
          <div>
            <div class="text-slate-400 text-xs font-medium mb-3 uppercase tracking-wider">Statut</div>
            <div class="space-y-2">
              <label class="flex items-center gap-3 cursor-pointer group">
                <input type="checkbox" class="filter-checkbox" checked style="appearance:none;width:16px;height:16px;border:1.5px solid #3f3f5a;border-radius:4px;background:transparent;cursor:pointer;transition:all .2s;position:relative;flex-shrink:0;" />
                <span class="text-slate-400 text-sm group-hover:text-slate-200 transition-colors">Vérifié ✓</span>
              </label>
              <label class="flex items-center gap-3 cursor-pointer group">
                <input type="checkbox" class="filter-checkbox" style="appearance:none;width:16px;height:16px;border:1.5px solid #3f3f5a;border-radius:4px;background:transparent;cursor:pointer;transition:all .2s;position:relative;flex-shrink:0;" />
                <span class="text-slate-400 text-sm group-hover:text-slate-200 transition-colors">Nouvellement rejoint</span>
              </label>
              <label class="flex items-center gap-3 cursor-pointer group">
                <input type="checkbox" class="filter-checkbox" style="appearance:none;width:16px;height:16px;border:1.5px solid #3f3f5a;border-radius:4px;background:transparent;cursor:pointer;transition:all .2s;position:relative;flex-shrink:0;" />
                <span class="text-slate-400 text-sm group-hover:text-slate-200 transition-colors">Actif ce mois</span>
              </label>
            </div>
          </div>
        </div>

        <!-- Become creator promo -->
        <div class="become-card p-5 relative overflow-hidden">
          <div class="orb" style="width:100px;height:100px;background:rgba(124,58,237,.25);top:-30px;right:-30px;filter:blur(30px)"></div>
          <div class="relative z-10">
            <div class="text-2xl mb-2">🚀</div>
            <div class="font-display text-white font-700 text-base mb-2">Partagez votre talent</div>
            <p class="text-slate-400 text-xs leading-relaxed mb-4">Rejoignez 847 créateurs et monétisez vos ressources digitales. Commission de 70% sur chaque vente.</p>
            <div class="flex items-center gap-2 mb-3">
              <div class="flex -space-x-2">
                <div class="w-6 h-6 rounded-full border-2 border-[#111118] bg-gradient-to-br from-violet-500 to-cyan-400 flex items-center justify-center text-white text-xs">S</div>
                <div class="w-6 h-6 rounded-full border-2 border-[#111118] bg-gradient-to-br from-amber-500 to-rose-400 flex items-center justify-center text-white text-xs">K</div>
                <div class="w-6 h-6 rounded-full border-2 border-[#111118] bg-gradient-to-br from-emerald-500 to-cyan-400 flex items-center justify-center text-white text-xs">M</div>
              </div>
              <span class="text-slate-500 text-xs">+844 créateurs actifs</span>
            </div>
            <button class="btn-primary text-white text-xs px-4 py-2 rounded-lg font-medium w-full" onclick="showToast('Candidature envoyée ! 🎉','Notre équipe vous contactera sous 48h')">
              Postuler maintenant →
            </button>
          </div>
        </div>

      </div>
    </aside>

    <!-- ===== CREATORS GRID ===== -->
    <div class="flex-1 min-w-0">

      <!-- Sort bar -->
      <div class="bg-[var(--c-surface)] border border-[var(--c-border)] rounded-xl flex items-center justify-between px-4 py-3 mb-5 gap-4">
        <div class="flex items-center gap-3 text-sm text-slate-400">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"/></svg>
          <span class="hidden sm:inline">Trier par :</span>
          <select class="sort-select" id="sortSelect" onchange="sortCreators(this.value)">
            <option value="popular">Popularité</option>
            <option value="sales">Meilleures ventes</option>
            <option value="rating">Meilleures notes</option>
            <option value="newest">Nouveaux</option>
            <option value="followers">Abonnés</option>
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

      <!-- Grid -->
      <div id="creatorsGrid" class="grid sm:grid-cols-2 xl:grid-cols-3 gap-5 mb-8"></div>

      <!-- Pagination -->
      <div class="flex items-center justify-center gap-2 mt-6">
        <button class="page-btn"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg></button>
        <button class="page-btn active">1</button>
        <button class="page-btn" onclick="changePage(this)">2</button>
        <button class="page-btn" onclick="changePage(this)">3</button>
        <span class="text-slate-600 text-sm px-2">...</span>
        <button class="page-btn" onclick="changePage(this)">9</button>
        <button class="page-btn"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></button>
      </div>
    </div>
  </div>
</div>

<!-- ===== FOOTER ===== -->
<footer class="border-t border-white/5 py-10">
  <div class="max-w-7xl mx-auto px-6">
    <div class="flex flex-col md:flex-row items-center justify-between gap-4 text-slate-600 text-xs">
      <div class="flex items-center gap-2">
        <div class="w-6 h-6 rounded-md bg-gradient-to-br from-violet-600 to-cyan-500 flex items-center justify-center">
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
/* ─── CURSOR ─── */
const cursorEl = document.getElementById('cursor');
const ringEl   = document.getElementById('cursorRing');
let mx=0,my=0,rx=0,ry=0;
document.addEventListener('mousemove', e => { mx=e.clientX; my=e.clientY; cursorEl.style.left=mx+'px'; cursorEl.style.top=my+'px'; });
(function animRing(){ rx+=(mx-rx)*.12; ry+=(my-ry)*.12; ringEl.style.left=rx+'px'; ringEl.style.top=ry+'px'; requestAnimationFrame(animRing); })();
function attachCursor() {
  document.querySelectorAll('a,button,input,select,label,.creator-card,.lb-row').forEach(el => {
    el.addEventListener('mouseenter',()=>{ cursorEl.style.width='20px'; cursorEl.style.height='20px'; ringEl.style.width='50px'; ringEl.style.height='50px'; });
    el.addEventListener('mouseleave',()=>{ cursorEl.style.width='12px'; cursorEl.style.height='12px'; ringEl.style.width='36px'; ringEl.style.height='36px'; });
  });
}

/* ─── TOAST ─── */
function showToast(msg, sub) {
  document.getElementById('toastMsg').textContent = msg;
  document.getElementById('toastSub').textContent = sub || 'PixelVault';
  const t = document.getElementById('toast');
  t.classList.add('show');
  setTimeout(() => t.classList.remove('show'), 3200);
}

/* ─── FOLLOW ─── */
function toggleFollow(btn) {
  const following = btn.classList.toggle('following');
  btn.textContent = following ? '✓ Suivi' : '+ Suivre';
  showToast(following ? 'Créateur suivi ! 🎉' : 'Vous ne suivez plus ce créateur', following ? 'Vous recevrez ses nouvelles' : '');
}

/* ─── CREATORS DATA ─── */
const creators = [
  { id:1,  name:'Sophie Martin',    initials:'S', grad:'from-violet-600 to-cyan-500',   role:'UI/UX Designer & Illustratrice', verified:true,  products:48, sales:'2.1k', followers:'8.4k', rating:4.9, reviews:312, years:'3 ans',
    specialties:['Figma','UI Design','3D Icons'], coverColor:'from-violet-900/60 to-cyan-900/40', badge:null, bio:'Designer spécialisée dans la création d\'interfaces utilisateur élégantes.' },
  { id:2,  name:'Marcus Chen',      initials:'M', grad:'from-cyan-500 to-sky-600',       role:'Motion Designer & Développeur',  verified:true,  products:76, sales:'5.2k', followers:'14k',  rating:5.0, reviews:487, years:'5 ans',
    specialties:['Framer','React','Motion'],     coverColor:'from-cyan-900/60 to-sky-900/40',    badge:'👑 Top',  bio:'Senior Motion Designer primé, créateur du Motion UI Library.' },
  { id:3,  name:'Karim Benali',     initials:'K', grad:'from-amber-500 to-orange-500',   role:'Développeur Full Stack',         verified:true,  products:34, sales:'1.8k', followers:'5.9k', rating:4.8, reviews:198, years:'2 ans',
    specialties:['Next.js','TypeScript','APIs'], coverColor:'from-amber-900/60 to-orange-900/40',badge:null,     bio:'Développeur full-stack passionné par les outils pour développeurs.' },
  { id:4,  name:'Amina Diallo',     initials:'A', grad:'from-rose-500 to-pink-600',      role:'Illustratrice & Branding',       verified:true,  products:29, sales:'1.2k', followers:'7.1k', rating:4.9, reviews:143, years:'4 ans',
    specialties:['Illustration','Branding','SVG'],coverColor:'from-rose-900/60 to-pink-900/40', badge:'🌟 New',  bio:'Illustratrice primée spécialisée dans le branding et les identités visuelles.' },
  { id:5,  name:'Pierre Dubois',    initials:'P', grad:'from-emerald-500 to-teal-600',   role:'Formateur & Développeur',        verified:false, products:22, sales:'0.9k', followers:'3.4k', rating:4.7, reviews:89,  years:'1 an',
    specialties:['Cours','Figma','Tailwind'],    coverColor:'from-emerald-900/60 to-teal-900/40',badge:null,     bio:'Formateur autodidacte, créateur de cours sur le design et le développement.' },
  { id:6,  name:'Yuki Tanaka',      initials:'Y', grad:'from-indigo-500 to-purple-600',  role:'UI Designer & Framer Expert',    verified:true,  products:41, sales:'3.1k', followers:'11k',  rating:5.0, reviews:276, years:'4 ans',
    specialties:['Framer','Webflow','CSS'],      coverColor:'from-indigo-900/60 to-purple-900/40',badge:'🔥 Hot', bio:'Experte Framer et Webflow, connue pour ses animations spectaculaires.' },
  { id:7,  name:'Lisa Torres',      initials:'L', grad:'from-fuchsia-500 to-pink-500',   role:'Motion Designer & After Effects', verified:true,  products:18, sales:'0.7k', followers:'2.8k', rating:4.6, reviews:56,  years:'1 an',
    specialties:['After Effects','Motion','LUT'],coverColor:'from-fuchsia-900/60 to-pink-900/40',badge:null,     bio:'Motion designer spécialisée dans les effets visuels et les LUTs cinématiques.' },
  { id:8,  name:'Théo Leroy',       initials:'T', grad:'from-sky-500 to-blue-600',       role:'Dev & Plugin Maker',             verified:true,  products:55, sales:'2.9k', followers:'9.2k', rating:4.9, reviews:321, years:'3 ans',
    specialties:['Plugins','JS','Figma API'],    coverColor:'from-sky-900/60 to-blue-900/40',   badge:null,     bio:'Développeur spécialisé dans les plugins Figma et les outils no-code avancés.' },
  { id:9,  name:'Nadia Rahman',     initials:'N', grad:'from-teal-500 to-cyan-400',      role:'Brand Designer & Typographe',    verified:false, products:14, sales:'0.5k', followers:'1.9k', rating:4.5, reviews:38,  years:'8 mois',
    specialties:['Branding','Typographie','AI'], coverColor:'from-teal-900/60 to-cyan-900/40',  badge:'🆕 New',  bio:'Designer fraîchement arrivée, spécialisée dans l\'identité visuelle et la typographie.' },
];

/* ─── LEADERBOARD ─── */
const topCreators = [...creators].sort((a,b) => parseFloat(b.sales) - parseFloat(a.sales)).slice(0,5);
function renderLeaderboard() {
  const lb = document.getElementById('leaderboard');
  lb.innerHTML = topCreators.map((c,i) => `
    <div class="lb-row ${i===0?'top':''}" onclick="openModal(${c.id-1})" style="animation:fadeUp .4s ease ${i*.07}s both;">
      <span class="rank-num ${i===0?'rank-1':i===1?'rank-2':i===2?'rank-3':'rank-other'}">${i+1}</span>
      <div class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-700 text-white flex-shrink-0"
           style="background:linear-gradient(135deg,${gradToColors(c.grad)});">${c.initials}</div>
      <div class="flex-1 min-w-0">
        <div class="text-white text-xs font-600 truncate">${c.name}</div>
        <div class="text-slate-500 text-xs">${c.sales} ventes</div>
      </div>
      <div class="stars text-xs">${c.rating === 5.0 ? '★★★★★' : '★★★★☆'}</div>
    </div>
  `).join('');
}
function gradToColors(g) {
  const map = {
    'from-violet-600 to-cyan-500':'#7c3aed,#06b6d4',
    'from-cyan-500 to-sky-600':'#06b6d4,#0284c7',
    'from-amber-500 to-orange-500':'#f59e0b,#f97316',
    'from-rose-500 to-pink-600':'#f43f5e,#db2777',
    'from-emerald-500 to-teal-600':'#10b981,#0d9488',
    'from-indigo-500 to-purple-600':'#6366f1,#9333ea',
    'from-fuchsia-500 to-pink-500':'#d946ef,#ec4899',
    'from-sky-500 to-blue-600':'#0ea5e9,#2563eb',
    'from-teal-500 to-cyan-400':'#14b8a6,#22d3ee',
  };
  return map[g] || '#7c3aed,#06b6d4';
}
renderLeaderboard();

/* ─── RENDER CREATORS ─── */
let currentView = 'grid';
function renderGrid(data) {
  const grid = document.getElementById('creatorsGrid');
  if (currentView === 'grid') {
    grid.className = 'grid sm:grid-cols-2 xl:grid-cols-3 gap-5 mb-8';
    grid.innerHTML = data.map((c,i) => `
      <div class="creator-card" style="animation:cardIn .5s ease ${i*.06}s both;" onclick="openModal(${c.id-1})">
        <!-- Cover -->
        <div class="creator-cover bg-gradient-to-br ${c.coverColor}" style="position:relative;">
          ${c.badge ? `<div class="absolute top-3 left-3 z-10 text-xs px-2.5 py-1 rounded-full font-medium backdrop-blur-sm"
            style="background:rgba(0,0,0,.5);border:1px solid rgba(255,255,255,.15);color:#e2e8f0;">${c.badge}</div>` : ''}
        </div>
        <!-- Avatar row -->
        <div style="padding:0 16px;margin-top:-28px;position:relative;z-index:2;display:flex;align-items:flex-end;justify-content:space-between;margin-bottom:12px;">
          <div style="position:relative;">
            <div class="creator-avatar" style="background:linear-gradient(135deg,${gradToColors(c.grad)});width:56px;height:56px;font-size:18px;">${c.initials}</div>
            ${c.verified ? `<div class="verified-badge"><svg class="w-2.5 h-2.5 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg></div>` : ''}
          </div>
          <button class="follow-btn" onclick="event.stopPropagation();toggleFollow(this)">+ Suivre</button>
        </div>
        <!-- Info -->
        <div class="px-4 pb-4">
          <div class="flex items-center gap-1.5 mb-0.5">
            <h3 class="font-display text-white font-700 text-base">${c.name}</h3>
          </div>
          <p class="text-slate-500 text-xs mb-3">${c.role}</p>
          <!-- Specialties -->
          <div class="flex flex-wrap gap-1.5 mb-4">
            ${c.specialties.slice(0,3).map(s => `<span class="text-xs px-2 py-0.5 rounded-full border border-white/10 text-slate-400 bg-white/3">${s}</span>`).join('')}
          </div>
          <!-- Stats -->
          <div class="grid grid-cols-3 gap-2 mb-4">
            <div class="bg-white/3 rounded-lg p-2 text-center border border-white/5">
              <div class="font-display text-white font-700 text-sm">${c.products}</div>
              <div class="text-slate-600 text-xs">produits</div>
            </div>
            <div class="bg-white/3 rounded-lg p-2 text-center border border-white/5">
              <div class="font-display text-white font-700 text-sm">${c.sales}</div>
              <div class="text-slate-600 text-xs">ventes</div>
            </div>
            <div class="bg-white/3 rounded-lg p-2 text-center border border-white/5">
              <div class="font-display text-white font-700 text-sm">${c.followers}</div>
              <div class="text-slate-600 text-xs">abonnés</div>
            </div>
          </div>
          <!-- Rating bar -->
          <div class="flex items-center gap-2 mb-1">
            <div class="stars text-xs">${buildStars(c.rating)}</div>
            <span class="text-slate-500 text-xs">${c.rating} (${c.reviews})</span>
          </div>
          <div class="prog-track mt-2">
            <div class="prog-fill" style="width:${(c.rating/5*100).toFixed(0)}%;"></div>
          </div>
        </div>
      </div>
    `).join('');
  } else {
    // List view
    grid.className = 'flex flex-col gap-3 mb-8';
    grid.innerHTML = data.map((c,i) => `
      <div style="background:var(--c-surface);border:1px solid var(--c-border);border-radius:16px;display:flex;align-items:center;gap:16px;padding:14px 16px;transition:transform .25s,border-color .25s,box-shadow .25s;cursor:pointer;animation:cardIn .4s ease ${i*.04}s both;"
           onmouseenter="this.style.transform='translateX(4px)';this.style.borderColor='rgba(124,58,237,.35)';"
           onmouseleave="this.style.transform='';this.style.borderColor='var(--c-border)';"
           onclick="openModal(${c.id-1})">
        <div style="position:relative;flex-shrink:0;">
          <div class="creator-avatar" style="background:linear-gradient(135deg,${gradToColors(c.grad)});width:52px;height:52px;font-size:18px;">${c.initials}</div>
          ${c.verified ? `<div class="verified-badge"><svg class="w-2.5 h-2.5 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg></div>` : ''}
        </div>
        <div class="flex-1 min-w-0">
          <div class="flex items-center gap-2 mb-0.5">
            <span class="font-display text-white font-700 text-sm">${c.name}</span>
            ${c.badge ? `<span class="text-xs px-1.5 py-0.5 rounded bg-white/8 text-slate-400">${c.badge}</span>` : ''}
          </div>
          <div class="text-slate-500 text-xs mb-2">${c.role}</div>
          <div class="flex gap-1.5">
            ${c.specialties.slice(0,2).map(s=>`<span class="text-xs px-2 py-0.5 rounded-full border border-white/10 text-slate-400">${s}</span>`).join('')}
          </div>
        </div>
        <div class="flex items-center gap-5 flex-shrink-0 text-center hidden sm:flex">
          <div><div class="font-display text-white font-700 text-sm">${c.products}</div><div class="text-slate-600 text-xs">produits</div></div>
          <div><div class="font-display text-white font-700 text-sm">${c.sales}</div><div class="text-slate-600 text-xs">ventes</div></div>
          <div class="stars text-xs">${buildStars(c.rating)}</div>
        </div>
        <button class="follow-btn flex-shrink-0" onclick="event.stopPropagation();toggleFollow(this)">+ Suivre</button>
      </div>
    `).join('');
  }
  attachCursor();
}

function buildStars(r) {
  const f = Math.floor(r);
  return Array.from({length:5}, (_,i) => i<f ? '★' : '☆').join('');
}

renderGrid(creators);

/* ─── VIEW TOGGLE ─── */
function setView(v) {
  currentView = v;
  document.getElementById('gridBtn').classList.toggle('active', v==='grid');
  document.getElementById('listBtn').classList.toggle('active', v==='list');
  renderGrid(creators);
}

/* ─── SORT ─── */
function sortCreators(val) {
  let s = [...creators];
  if (val==='sales')     s.sort((a,b) => parseFloat(b.sales)-parseFloat(a.sales));
  if (val==='rating')    s.sort((a,b) => b.rating-a.rating);
  if (val==='newest')    s.reverse();
  if (val==='followers') s.sort((a,b) => parseFloat(b.followers)-parseFloat(a.followers));
  renderGrid(s);
}

/* ─── MODAL ─── */
function openModal(idx) {
  const c = creators[idx];
  if(!c) return;
  document.getElementById('mAvatar').textContent = c.initials;
  document.getElementById('mAvatar').style.background = `linear-gradient(135deg,${gradToColors(c.grad)})`;
  document.getElementById('mName').textContent = c.name;
  document.getElementById('mSpeciality').textContent = c.role;
  document.getElementById('mRating').textContent = `${c.rating} • ${c.reviews} avis`;
  document.getElementById('mStars').textContent = buildStars(c.rating);
  document.getElementById('mProducts').textContent = c.products;
  document.getElementById('mSales').textContent = c.sales;
  document.getElementById('mFollowers').textContent = c.followers;
  document.getElementById('mYears').textContent = c.years;
  document.getElementById('mBio').textContent = c.bio;
  // Tags
  const colors = ['violet','cyan','amber'];
  document.getElementById('mTags').innerHTML = c.specialties.map((s,i) => {
    const col = colors[i] || '';
    return col
      ? `<span class="text-xs px-3 py-1 rounded-full border border-${col}-500/30 text-${col}-400 bg-${col}-500/10">${s}</span>`
      : `<span class="text-xs px-3 py-1 rounded-full border border-white/10 text-slate-400">${s}</span>`;
  }).join('');
  document.getElementById('modal').classList.add('open');
}
function closeModal() { document.getElementById('modal').classList.remove('open'); }
document.getElementById('modal').addEventListener('click', e => { if(e.target===document.getElementById('modal')) closeModal(); });
document.addEventListener('keydown', e => { if(e.key==='Escape') closeModal(); });

/* ─── SEARCH ─── */
document.getElementById('navSearch').addEventListener('input', function() {
  const q = this.value.toLowerCase();
  const filtered = q ? creators.filter(c =>
    c.name.toLowerCase().includes(q) ||
    c.role.toLowerCase().includes(q) ||
    c.specialties.some(s => s.toLowerCase().includes(q))
  ) : creators;
  document.getElementById('resultCount').textContent = filtered.length;
  renderGrid(filtered);
});

/* ─── CAT PILLS ─── */
document.querySelectorAll('.cat-pill').forEach(pill => {
  pill.addEventListener('click', () => {
    pill.closest('div').querySelectorAll('.cat-pill').forEach(p => p.classList.remove('active'));
    pill.classList.add('active');
  });
});

/* ─── PAGINATION ─── */
function changePage(btn) {
  document.querySelectorAll('.page-btn').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
  window.scrollTo({ top: 280, behavior:'smooth' });
  const grid = document.getElementById('creatorsGrid');
  grid.style.opacity = '0'; grid.style.transform = 'translateY(10px)'; grid.style.transition = 'all .3s';
  setTimeout(() => {
    renderGrid([...creators].sort(() => Math.random()-.5));
    grid.style.opacity = '1'; grid.style.transform = 'translateY(0)';
  }, 280);
}

/* ─── FILTER CHECKBOXES (style inject) ─── */
document.querySelectorAll('.filter-checkbox').forEach(cb => {
  cb.addEventListener('change', function() {
    this.style.background = this.checked ? '#7c3aed' : 'transparent';
    this.style.borderColor = this.checked ? '#7c3aed' : '#3f3f5a';
  });
});

/* ─── INIT CURSOR ATTACH ─── */
attachCursor();
</script>
</body>
</html>
