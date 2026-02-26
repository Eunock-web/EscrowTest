<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>PixelVault — Tarifs</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,300&display=swap" rel="stylesheet"/>
  <style>
    :root {
      --c-bg:      #09090f;
      --c-surface: #111118;
      --c-border:  #1e1e2e;
      --c-accent:  #7c3aed;
      --c-accent2: #06b6d4;
      --c-gold:    #f59e0b;
      --c-text:    #e2e8f0;
      --c-muted:   #64748b;
    }
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
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

    /* ── Noise overlay ── */
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

    /* ── Keyframes ── */
    @keyframes fadeUp    { from{opacity:0;transform:translateY(28px)} to{opacity:1;transform:translateY(0)} }
    @keyframes shimmer   { 0%{background-position:-200% 0} 100%{background-position:200% 0} }
    @keyframes pulseRing { 0%{transform:scale(1);opacity:.6} 100%{transform:scale(1.8);opacity:0} }
    @keyframes float     { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-10px)} }
    @keyframes cardIn    { from{opacity:0;transform:translateY(20px) scale(.97)} to{opacity:1;transform:translateY(0) scale(1)} }
    @keyframes borderPulse {
      0%,100%{box-shadow:0 0 0 0 rgba(124,58,237,0)}
      50%{box-shadow:0 0 0 4px rgba(124,58,237,.2), 0 0 40px rgba(124,58,237,.15)}
    }
    @keyframes checkPop  { 0%{transform:scale(0) rotate(-15deg);opacity:0} 60%{transform:scale(1.2) rotate(5deg)} 100%{transform:scale(1) rotate(0);opacity:1} }
    @keyframes priceFlip { 0%{opacity:0;transform:translateY(-12px)} 100%{opacity:1;transform:translateY(0)} }
    @keyframes badgeFloat{ 0%,100%{transform:translateY(0) rotate(-3deg)} 50%{transform:translateY(-6px) rotate(-3deg)} }
    @keyframes spinSlow  { from{transform:rotate(0deg)} to{transform:rotate(360deg)} }
    @keyframes countUp   { from{opacity:0;transform:scale(.8)} to{opacity:1;transform:scale(1)} }
    @keyframes slideDown { from{opacity:0;max-height:0} to{opacity:1;max-height:600px} }
    @keyframes slideUp   { from{opacity:1;max-height:600px} to{opacity:0;max-height:0} }
    @keyframes ticker    { from{transform:translateX(0)} to{transform:translateX(-50%)} }

    .anim-fade-up { animation: fadeUp .65s ease forwards; }
    .delay-1 { animation-delay:.08s; opacity:0; }
    .delay-2 { animation-delay:.2s;  opacity:0; }
    .delay-3 { animation-delay:.32s; opacity:0; }
    .delay-4 { animation-delay:.44s; opacity:0; }
    .delay-5 { animation-delay:.56s; opacity:0; }
    .delay-6 { animation-delay:.68s; opacity:0; }

    /* ── Nav ── */
    nav { backdrop-filter:blur(16px); -webkit-backdrop-filter:blur(16px); }

    /* ── Gradient text ── */
    .grad-text {
      background: linear-gradient(135deg,#a78bfa 0%,#22d3ee 50%,#f59e0b 100%);
      -webkit-background-clip: text; -webkit-text-fill-color: transparent;
    }

    /* ── Scrollbar ── */
    ::-webkit-scrollbar { width:5px; }
    ::-webkit-scrollbar-track { background:var(--c-bg); }
    ::-webkit-scrollbar-thumb { background:rgba(124,58,237,.4); border-radius:3px; }

    /* ── Buttons ── */
    .btn-primary {
      background: linear-gradient(135deg,#7c3aed,#5b21b6);
      position: relative; overflow: hidden;
      transition: transform .2s, box-shadow .2s;
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

    /* ── Toggle switch ── */
    .toggle-wrap {
      display:inline-flex; align-items:center;
      background:var(--c-surface);
      border:1px solid var(--c-border);
      border-radius:50px; padding:4px;
      position:relative;
    }
    .toggle-btn {
      padding:8px 22px; border-radius:40px;
      font-size:14px; font-weight:500;
      cursor:pointer; transition:all .3s;
      color:#64748b; border:none; background:transparent;
      font-family:'DM Sans',sans-serif;
      position:relative; z-index:1;
    }
    .toggle-btn.active { color:#fff; }
    .toggle-slider {
      position:absolute; top:4px; left:4px;
      height:calc(100% - 8px);
      background:linear-gradient(135deg,#7c3aed,#5b21b6);
      border-radius:40px;
      transition:all .35s cubic-bezier(.4,0,.2,1);
      box-shadow:0 0 20px rgba(124,58,237,.4);
    }

    /* ── Pricing card ── */
    .pricing-card {
      background: var(--c-surface);
      border: 1px solid var(--c-border);
      border-radius: 24px;
      position: relative; overflow: hidden;
      transition: transform .35s ease, box-shadow .35s ease, border-color .3s;
    }
    .pricing-card:hover {
      transform: translateY(-8px);
      box-shadow: 0 24px 70px rgba(124,58,237,.14);
    }
    .pricing-card.featured {
      border-color: rgba(124,58,237,.5);
      animation: borderPulse 3s ease-in-out infinite;
      transform: scale(1.04);
    }
    .pricing-card.featured:hover { transform: scale(1.04) translateY(-8px); }

    /* ── Check item ── */
    .check-item {
      display:flex; align-items:flex-start; gap:10px;
    }
    .check-icon {
      width:18px; height:18px; border-radius:50%;
      display:flex; align-items:center; justify-content:center;
      flex-shrink:0; margin-top:1px;
    }
    .check-icon.yes  { background:rgba(16,185,129,.15); }
    .check-icon.no   { background:rgba(100,116,139,.1); }
    .check-icon.star { background:rgba(245,158,11,.15); }

    /* ── Comparison table ── */
    .comp-table {
      border-collapse:collapse; width:100%;
    }
    .comp-table th, .comp-table td {
      padding:14px 18px; text-align:center;
      border-bottom:1px solid var(--c-border);
    }
    .comp-table th { font-family:'Syne',sans-serif; font-weight:700; }
    .comp-table tr:last-child td, .comp-table tr:last-child th { border-bottom:none; }
    .comp-table tbody tr { transition:background .2s; }
    .comp-table tbody tr:hover { background:rgba(124,58,237,.04); }
    .comp-table td:first-child { text-align:left; color:#94a3b8; font-size:14px; }
    .comp-table .col-featured { background:rgba(124,58,237,.06); }
    .comp-table .col-featured th {
      background:rgba(124,58,237,.1);
      border-bottom:1px solid rgba(124,58,237,.2);
    }

    /* ── FAQ ── */
    .faq-item {
      border:1px solid var(--c-border);
      border-radius:14px; overflow:hidden;
      transition:border-color .2s;
    }
    .faq-item.open { border-color:rgba(124,58,237,.35); }
    .faq-trigger {
      width:100%; display:flex; align-items:center; justify-content:space-between;
      padding:18px 20px; cursor:pointer; background:transparent; border:none;
      text-align:left; font-family:'DM Sans',sans-serif;
      transition:background .2s;
    }
    .faq-trigger:hover { background:rgba(124,58,237,.04); }
    .faq-chevron {
      width:28px; height:28px; border-radius:8px;
      border:1px solid var(--c-border);
      display:flex; align-items:center; justify-content:center;
      flex-shrink:0; transition:all .3s; color:#64748b;
    }
    .faq-item.open .faq-chevron {
      background:rgba(124,58,237,.15);
      border-color:rgba(124,58,237,.4); color:#a78bfa;
      transform:rotate(180deg);
    }
    .faq-body {
      max-height:0; overflow:hidden;
      transition:max-height .4s cubic-bezier(.4,0,.2,1), padding .3s;
      padding:0 20px;
    }
    .faq-item.open .faq-body { max-height:400px; padding-bottom:18px; }

    /* ── Testimonial card ── */
    .testi-card {
      background:linear-gradient(135deg,rgba(124,58,237,.08),rgba(6,182,212,.04));
      border:1px solid rgba(124,58,237,.2);
      border-radius:18px;
      transition:border-color .3s, transform .3s;
    }
    .testi-card:hover { border-color:rgba(124,58,237,.45); transform:translateY(-4px); }

    /* ── Comparison section bg ── */
    .comp-wrapper {
      background:var(--c-surface);
      border:1px solid var(--c-border);
      border-radius:24px; overflow:hidden;
    }

    /* ── Badge pill ── */
    .badge-new {
      animation:badgeFloat 3s ease-in-out infinite;
      display:inline-flex; align-items:center; gap:6px;
    }

    /* ── Stat highlight ── */
    .stat-num {
      font-family:'Syne',sans-serif; font-weight:800;
      background:linear-gradient(135deg,#a78bfa,#22d3ee);
      -webkit-background-clip:text; -webkit-text-fill-color:transparent;
    }

    /* ── Ticker ── */
    .ticker-wrap { overflow:hidden; }
    .ticker-track { display:flex; animation:ticker 30s linear infinite; white-space:nowrap; }
    .ticker-track:hover { animation-play-state:paused; }

    /* ── Popular badge on featured card ── */
    .popular-badge {
      position:absolute; top:-1px; left:50%; transform:translateX(-50%);
      background:linear-gradient(135deg,#7c3aed,#06b6d4);
      color:#fff; font-size:11px; font-weight:700;
      font-family:'Syne',sans-serif; letter-spacing:.05em;
      padding:5px 18px; border-radius:0 0 14px 14px;
      white-space:nowrap;
    }

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

    /* ── Floating decorative cards ── */
    .deco-card {
      position:absolute;
      background:var(--c-surface);
      border:1px solid var(--c-border);
      border-radius:14px; padding:12px 14px;
      box-shadow:0 8px 32px rgba(0,0,0,.4);
    }

    /* ── Usage meter ── */
    .meter-bar {
      height:6px; border-radius:3px;
      background:var(--c-border);
      overflow:hidden; position:relative;
    }
    .meter-fill {
      height:100%; border-radius:3px;
      transition:width 1.5s cubic-bezier(.22,1,.36,1);
    }

    /* Stars */
    .stars { color: var(--c-gold); }

    /* ── Annual savings pill ── */
    .savings-pill {
      display:inline-flex; align-items:center; gap:5px;
      background:rgba(16,185,129,.12);
      border:1px solid rgba(16,185,129,.3);
      color:#34d399; font-size:11px; font-weight:600;
      padding:3px 10px; border-radius:20px;
      font-family:'Syne',sans-serif;
    }

    /* ── Price animation ── */
    .price-num {
      display:inline-block;
      animation:priceFlip .3s ease forwards;
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

<!-- ===== NAV ===== -->
<nav class="fixed top-0 inset-x-0 z-50 border-b border-white/5 bg-[#09090f]/80">
  <div class="max-w-7xl mx-auto px-6 h-16 flex items-center justify-between">
    <a href="index.html" class="flex items-center gap-2">
      <div class="w-8 h-8 rounded-lg bg-linear-to-br from-violet-600 to-cyan-500 flex items-center justify-center">
        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z"/></svg>
      </div>
      <span class="font-display text-lg font-700 text-white tracking-tight">Pixel<span class="grad-text">Vault</span></span>
    </a>

    <div class="hidden md:flex items-center gap-8 text-sm text-slate-400">
      <a href="/"    class="hover:text-white transition-colors">Accueil</a>
      <a href="/explorer" class="hover:text-white transition-colors">Explorer</a>
      <a href="/createurs"class="hover:text-white transition-colors">Créateurs</a>
      <a href="/tarifs"   class="text-violet-400 font-medium">Tarifs</a>
    </div>

    <div class="flex items-center gap-3">
      <button class="hidden sm:block text-sm text-slate-400 hover:text-white transition-colors px-4 py-2">Connexion</button>
      <button class="btn-primary text-white text-sm px-5 py-2 rounded-lg font-medium" onclick="showToast('Inscription gratuite !','Aucune carte bancaire requise')">Commencer</button>
    </div>
  </div>
</nav>

<!-- ===== HERO ===== -->
<section class="relative pt-16 overflow-hidden">
  <div class="orb" style="width:600px;height:400px;background:rgba(124,58,237,.13);top:-150px;left:-150px;"></div>
  <div class="orb" style="width:400px;height:400px;background:rgba(6,182,212,.09);top:0;right:-100px;"></div>
  <div class="orb" style="width:300px;height:300px;background:rgba(245,158,11,.06);bottom:0;left:45%;"></div>

  <div class="max-w-7xl mx-auto px-6 pt-16 pb-6 text-center relative z-10">
    <!-- Breadcrumb -->
    <div class="anim-fade-up delay-1 flex items-center justify-center gap-2 text-sm text-slate-500 mb-8">
      <a href="/" class="hover:text-slate-300 transition-colors">Accueil</a>
      <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
      <span class="text-violet-400">Tarifs</span>
    </div>

    <!-- Badge -->
    <div class="anim-fade-up delay-1 flex justify-center mb-6">
      <div class="badge-new inline-flex items-center gap-2 px-3 py-1.5 rounded-full border border-violet-500/30 bg-violet-500/10 text-violet-300 text-xs font-medium">
        <span class="relative flex h-2 w-2">
          <span style="animation:pulseRing 1.8s ease-out infinite;position:absolute;inset:0;border-radius:9999px;border:1px solid #a78bfa;"></span>
          <span class="h-2 w-2 rounded-full bg-violet-400"></span>
        </span>
        Nouveau — Plan Créateur maintenant disponible
      </div>
    </div>

    <h1 class="anim-fade-up delay-2 font-display text-5xl md:text-7xl font-800 text-white leading-[.95] mb-6">
      Des tarifs <span class="grad-text">transparents</span><br/>pour tous les créatifs.
    </h1>
    <p class="anim-fade-up delay-3 text-slate-400 text-lg max-w-xl mx-auto mb-10 leading-relaxed">
      Commencez gratuitement. Passez au plan qui correspond à votre ambition. Sans engagement, sans frais cachés.
    </p>

    <!-- Billing toggle -->
    <div class="anim-fade-up delay-4 flex items-center justify-center gap-4 mb-4">
      <div class="toggle-wrap" id="billingToggle">
        <div class="toggle-slider" id="toggleSlider" style="width:100px;"></div>
        <button class="toggle-btn active" id="btnMonthly" onclick="setBilling('monthly')">Mensuel</button>
        <button class="toggle-btn" id="btnAnnual" onclick="setBilling('annual')">Annuel</button>
      </div>
      <span class="savings-pill">
        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M17.707 9.293a1 1 0 010 1.414l-7 7a1 1 0 01-1.414 0l-7-7A.997.997 0 012 10V5a3 3 0 013-3h5c.256 0 .512.098.707.293l7 7zM5 6a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/></svg>
        Économisez 30%
      </span>
    </div>
  </div>
</section>

<!-- ===== PRICING CARDS ===== -->
<section class="max-w-6xl mx-auto px-6 pb-8">
  <div class="grid md:grid-cols-3 gap-6 items-start" id="pricingCards">

    <!-- ── FREE ── -->
    <div class="pricing-card" style="animation:cardIn .6s ease .1s both;">
      <div class="p-7">
        <!-- Plan icon + name -->
        <div class="flex items-center gap-3 mb-5">
          <div class="w-10 h-10 rounded-xl bg-slate-700/40 border border-white/8 flex items-center justify-center">
            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
          </div>
          <div>
            <div class="font-display text-white font-700 text-lg">Starter</div>
            <div class="text-slate-500 text-xs">Pour découvrir</div>
          </div>
        </div>

        <!-- Price -->
        <div class="mb-6">
          <div class="flex items-end gap-1 mb-1">
            <span class="font-display text-white text-5xl font-800">0€</span>
            <span class="text-slate-500 text-sm mb-2">/mois</span>
          </div>
          <div class="text-slate-500 text-xs">Toujours gratuit, aucune carte requise</div>
        </div>

        <button class="btn-outline text-slate-300 w-full py-3 rounded-xl font-medium text-sm mb-7" onclick="showToast('Bienvenue !','Votre compte gratuit est prêt 🎉')">
          Commencer gratuitement
        </button>

        <!-- Features -->
        <div class="space-y-3.5">
          <div class="check-item">
            <div class="check-icon yes"><svg class="w-2.5 h-2.5 text-emerald-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg></div>
            <span class="text-slate-400 text-sm">Accès à <strong class="text-slate-200">50 produits</strong> gratuits</span>
          </div>
          <div class="check-item">
            <div class="check-icon yes"><svg class="w-2.5 h-2.5 text-emerald-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg></div>
            <span class="text-slate-400 text-sm">5 téléchargements / mois</span>
          </div>
          <div class="check-item">
            <div class="check-icon yes"><svg class="w-2.5 h-2.5 text-emerald-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg></div>
            <span class="text-slate-400 text-sm">Licence usage personnel</span>
          </div>
          <div class="check-item">
            <div class="check-icon yes"><svg class="w-2.5 h-2.5 text-emerald-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg></div>
            <span class="text-slate-400 text-sm">Accès à la communauté</span>
          </div>
          <div class="check-item">
            <div class="check-icon no"><svg class="w-2.5 h-2.5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></div>
            <span class="text-slate-600 text-sm">Produits premium illimités</span>
          </div>
          <div class="check-item">
            <div class="check-icon no"><svg class="w-2.5 h-2.5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></div>
            <span class="text-slate-600 text-sm">Licence commerciale</span>
          </div>
          <div class="check-item">
            <div class="check-icon no"><svg class="w-2.5 h-2.5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></div>
            <span class="text-slate-600 text-sm">Support prioritaire</span>
          </div>
        </div>
      </div>
    </div>

    <!-- ── PRO (featured) ── -->
    <div class="pricing-card featured" style="animation:cardIn .6s ease .2s both;">
      <div class="popular-badge">⚡ PLUS POPULAIRE</div>

      <!-- Gradient glow overlay -->
      <div class="absolute inset-0 pointer-events-none" style="background:radial-gradient(ellipse at 50% -20%,rgba(124,58,237,.18),transparent 65%);"></div>

      <div class="p-7 pt-10 relative z-10">
        <div class="flex items-center gap-3 mb-5">
          <div class="w-10 h-10 rounded-xl bg-linear-to-br from-violet-600/40 to-cyan-500/30 border border-violet-500/30 flex items-center justify-center">
            <svg class="w-5 h-5 text-violet-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
          </div>
          <div>
            <div class="font-display text-white font-700 text-lg">Pro</div>
            <div class="text-violet-400 text-xs">Pour les professionnels</div>
          </div>
        </div>

        <!-- Price -->
        <div class="mb-6">
          <div class="flex items-end gap-1 mb-1">
            <span class="font-display text-white text-5xl font-800">
              <span class="price-num" id="proPriceMonthly">19€</span>
            </span>
            <span class="text-slate-400 text-sm mb-2" id="proPricePeriod">/mois</span>
          </div>
          <div class="text-slate-400 text-xs" id="proPriceSub">Facturé 228€/an · Économisez 84€</div>
        </div>

        <button class="btn-primary text-white w-full py-3 rounded-xl font-medium text-sm mb-7 flex items-center justify-center gap-2" onclick="showToast('Essai Pro activé ! 🚀','14 jours gratuits, sans engagement')">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
          Démarrer l'essai gratuit
        </button>

        <!-- Features -->
        <div class="space-y-3.5">
          <div class="check-item">
            <div class="check-icon yes"><svg class="w-2.5 h-2.5 text-emerald-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg></div>
            <span class="text-slate-300 text-sm"><strong class="text-white">Produits premium illimités</strong></span>
          </div>
          <div class="check-item">
            <div class="check-icon yes"><svg class="w-2.5 h-2.5 text-emerald-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg></div>
            <span class="text-slate-300 text-sm">Téléchargements <strong class="text-white">illimités</strong></span>
          </div>
          <div class="check-item">
            <div class="check-icon yes"><svg class="w-2.5 h-2.5 text-emerald-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg></div>
            <span class="text-slate-300 text-sm"><strong class="text-white">Licence commerciale</strong> incluse</span>
          </div>
          <div class="check-item">
            <div class="check-icon yes"><svg class="w-2.5 h-2.5 text-emerald-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg></div>
            <span class="text-slate-300 text-sm">Mises à jour automatiques</span>
          </div>
          <div class="check-item">
            <div class="check-icon yes"><svg class="w-2.5 h-2.5 text-emerald-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg></div>
            <span class="text-slate-300 text-sm">Support prioritaire <strong class="text-white">24/7</strong></span>
          </div>
          <div class="check-item">
            <div class="check-icon yes"><svg class="w-2.5 h-2.5 text-emerald-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg></div>
            <span class="text-slate-300 text-sm">Accès anticipé aux nouveautés</span>
          </div>
          <div class="check-item">
            <div class="check-icon no"><svg class="w-2.5 h-2.5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></div>
            <span class="text-slate-600 text-sm">Publication de produits</span>
          </div>
        </div>

        <!-- 14-day guarantee note -->
        <div class="mt-6 pt-5 border-t border-violet-500/20">
          <div class="flex items-center gap-2 text-xs text-slate-500">
            <svg class="w-3.5 h-3.5 text-emerald-400 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            14 jours d'essai gratuit · Remboursement garanti 30 jours
          </div>
        </div>
      </div>
    </div>

    <!-- ── CREATOR ── -->
    <div class="pricing-card" style="animation:cardIn .6s ease .3s both;">
      <div class="p-7">
        <div class="flex items-center gap-3 mb-5">
          <div class="w-10 h-10 rounded-xl bg-linear-to-br from-amber-500/30 to-orange-500/20 border border-amber-500/25 flex items-center justify-center">
            <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
          </div>
          <div>
            <div class="font-display text-white font-700 text-lg">Créateur</div>
            <div class="text-amber-400 text-xs">Pour vendre vos créations</div>
          </div>
        </div>

        <!-- Price -->
        <div class="mb-6">
          <div class="flex items-end gap-1 mb-1">
            <span class="font-display text-white text-5xl font-800">
              <span class="price-num" id="creatorPriceMonthly">49€</span>
            </span>
            <span class="text-slate-400 text-sm mb-2" id="creatorPricePeriod">/mois</span>
          </div>
          <div class="text-slate-400 text-xs" id="creatorPriceSub">Facturé 588€/an · Économisez 216€</div>
        </div>

        <button class="w-full py-3 rounded-xl font-medium text-sm mb-7 border border-amber-500/40 text-amber-300 hover:bg-amber-500/10 transition-all flex items-center justify-center gap-2" onclick="showToast('Candidature reçue ! 🌟','Notre équipe vous contactera sous 24h')">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
          Devenir créateur
        </button>

        <!-- Features -->
        <div class="space-y-3.5">
          <div class="check-item">
            <div class="check-icon yes"><svg class="w-2.5 h-2.5 text-emerald-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg></div>
            <span class="text-slate-300 text-sm">Tout du plan <strong class="text-white">Pro</strong></span>
          </div>
          <div class="check-item">
            <div class="check-icon star"><svg class="w-2.5 h-2.5 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg></div>
            <span class="text-slate-300 text-sm"><strong class="text-white">Publication</strong> de produits illimitée</span>
          </div>
          <div class="check-item">
            <div class="check-icon star"><svg class="w-2.5 h-2.5 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg></div>
            <span class="text-slate-300 text-sm">Commission <strong class="text-white">70%</strong> sur chaque vente</span>
          </div>
          <div class="check-item">
            <div class="check-icon star"><svg class="w-2.5 h-2.5 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg></div>
            <span class="text-slate-300 text-sm">Dashboard analytics avancé</span>
          </div>
          <div class="check-item">
            <div class="check-icon star"><svg class="w-2.5 h-2.5 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg></div>
            <span class="text-slate-300 text-sm">Profil vérifié <strong class="text-white">✓</strong> et badge créateur</span>
          </div>
          <div class="check-item">
            <div class="check-icon star"><svg class="w-2.5 h-2.5 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg></div>
            <span class="text-slate-300 text-sm">Mise en avant dans la vitrine</span>
          </div>
          <div class="check-item">
            <div class="check-icon star"><svg class="w-2.5 h-2.5 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg></div>
            <span class="text-slate-300 text-sm">Support VIP dédié</span>
          </div>
        </div>
      </div>
    </div>

  </div>

  <!-- Guarantee strip -->
  <div class="mt-10 flex flex-wrap items-center justify-center gap-x-10 gap-y-3 text-slate-500 text-sm">
    <div class="flex items-center gap-2"><svg class="w-4 h-4 text-emerald-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>Remboursement 30 jours</div>
    <div class="flex items-center gap-2"><svg class="w-4 h-4 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>Paiements 100% sécurisés</div>
    <div class="flex items-center gap-2"><svg class="w-4 h-4 text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>Sans engagement, annulez quand vous voulez</div>
    <div class="flex items-center gap-2"><svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>Support disponible 7j/7</div>
  </div>
</section>

<!-- ===== TICKER ===== -->
<div class="ticker-wrap py-4 border-y border-white/5 bg-black/20 my-16">
  <div class="ticker-track gap-12 text-slate-500 text-sm font-medium">
    <span class="px-8">⚡ 12 000+ clients satisfaits</span>
    <span class="px-8">🎨 2 400 produits premium</span>
    <span class="px-8">⭐ Note moyenne 4.9/5</span>
    <span class="px-8">💳 Paiement sécurisé Stripe</span>
    <span class="px-8">🔄 Mises à jour incluses</span>
    <span class="px-8">🛡 Remboursement 30 jours</span>
    <span class="px-8">🚀 Accès instantané</span>
    <span class="px-8">⚡ 12 000+ clients satisfaits</span>
    <span class="px-8">🎨 2 400 produits premium</span>
    <span class="px-8">⭐ Note moyenne 4.9/5</span>
    <span class="px-8">💳 Paiement sécurisé Stripe</span>
    <span class="px-8">🔄 Mises à jour incluses</span>
    <span class="px-8">🛡 Remboursement 30 jours</span>
    <span class="px-8">🚀 Accès instantané</span>
  </div>
</div>

<!-- ===== COMPARISON TABLE ===== -->
<section class="max-w-5xl mx-auto px-6 mb-24">
  <div class="text-center mb-10">
    <div class="text-violet-400 text-sm font-medium mb-2">Comparer les plans</div>
    <h2 class="font-display text-3xl md:text-4xl font-700 text-white">Tout ce qui est <span class="grad-text">inclus</span></h2>
  </div>

  <div class="comp-wrapper overflow-x-auto">
    <table class="comp-table">
      <thead>
        <tr>
          <th class="text-left w-2/5 py-5 px-6"><span class="text-slate-400 text-sm font-medium">Fonctionnalités</span></th>
          <th class="text-slate-400 text-sm font-medium py-5">
            <div class="font-display text-white font-700 text-base mb-0.5">Starter</div>
            <div class="text-slate-500 text-xs">Gratuit</div>
          </th>
          <th class="col-featured py-5">
            <div class="font-display text-white font-700 text-base mb-0.5">Pro</div>
            <div class="text-violet-400 text-xs">19€/mois</div>
          </th>
          <th class="text-slate-400 text-sm font-medium py-5">
            <div class="font-display text-white font-700 text-base mb-0.5">Créateur</div>
            <div class="text-amber-400 text-xs">49€/mois</div>
          </th>
        </tr>
      </thead>
      <tbody>
        <tr><td colspan="4" class="py-2 px-6 text-xs text-slate-600 uppercase tracking-wider font-medium" style="background:rgba(255,255,255,.02)">Accès aux produits</td></tr>
        <tr>
          <td class="px-6">Produits gratuits</td>
          <td><span class="text-emerald-400 font-600">50</span></td>
          <td class="col-featured"><span class="text-emerald-400 font-600">Illimité</span></td>
          <td><span class="text-emerald-400 font-600">Illimité</span></td>
        </tr>
        <tr>
          <td class="px-6">Produits premium</td>
          <td><svg class="w-5 h-5 text-slate-700 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></td>
          <td class="col-featured"><svg class="w-5 h-5 text-emerald-400 mx-auto" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg></td>
          <td><svg class="w-5 h-5 text-emerald-400 mx-auto" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg></td>
        </tr>
        <tr>
          <td class="px-6">Téléchargements / mois</td>
          <td><span class="text-slate-300">5</span></td>
          <td class="col-featured"><span class="text-emerald-400 font-600">Illimité</span></td>
          <td><span class="text-emerald-400 font-600">Illimité</span></td>
        </tr>
        <tr><td colspan="4" class="py-2 px-6 text-xs text-slate-600 uppercase tracking-wider font-medium" style="background:rgba(255,255,255,.02)">Licences</td></tr>
        <tr>
          <td class="px-6">Licence usage personnel</td>
          <td><svg class="w-5 h-5 text-emerald-400 mx-auto" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg></td>
          <td class="col-featured"><svg class="w-5 h-5 text-emerald-400 mx-auto" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg></td>
          <td><svg class="w-5 h-5 text-emerald-400 mx-auto" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg></td>
        </tr>
        <tr>
          <td class="px-6">Licence commerciale</td>
          <td><svg class="w-5 h-5 text-slate-700 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></td>
          <td class="col-featured"><svg class="w-5 h-5 text-emerald-400 mx-auto" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg></td>
          <td><svg class="w-5 h-5 text-emerald-400 mx-auto" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg></td>
        </tr>
        <tr>
          <td class="px-6">Revente autorisée</td>
          <td><svg class="w-5 h-5 text-slate-700 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></td>
          <td class="col-featured"><svg class="w-5 h-5 text-slate-700 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></td>
          <td><svg class="w-5 h-5 text-emerald-400 mx-auto" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg></td>
        </tr>
        <tr><td colspan="4" class="py-2 px-6 text-xs text-slate-600 uppercase tracking-wider font-medium" style="background:rgba(255,255,255,.02)">Fonctionnalités créateur</td></tr>
        <tr>
          <td class="px-6">Publication de produits</td>
          <td><svg class="w-5 h-5 text-slate-700 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></td>
          <td class="col-featured"><svg class="w-5 h-5 text-slate-700 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></td>
          <td><svg class="w-5 h-5 text-emerald-400 mx-auto" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg></td>
        </tr>
        <tr>
          <td class="px-6">Commission par vente</td>
          <td><span class="text-slate-600 text-sm">—</span></td>
          <td class="col-featured"><span class="text-slate-600 text-sm">—</span></td>
          <td><span class="text-amber-400 font-600">70%</span></td>
        </tr>
        <tr>
          <td class="px-6">Analytics & revenus</td>
          <td><svg class="w-5 h-5 text-slate-700 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></td>
          <td class="col-featured"><svg class="w-5 h-5 text-slate-700 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></td>
          <td><svg class="w-5 h-5 text-emerald-400 mx-auto" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg></td>
        </tr>
        <tr><td colspan="4" class="py-2 px-6 text-xs text-slate-600 uppercase tracking-wider font-medium" style="background:rgba(255,255,255,.02)">Support & Extras</td></tr>
        <tr>
          <td class="px-6">Support communauté</td>
          <td><svg class="w-5 h-5 text-emerald-400 mx-auto" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg></td>
          <td class="col-featured"><svg class="w-5 h-5 text-emerald-400 mx-auto" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg></td>
          <td><svg class="w-5 h-5 text-emerald-400 mx-auto" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg></td>
        </tr>
        <tr>
          <td class="px-6">Support prioritaire 24/7</td>
          <td><svg class="w-5 h-5 text-slate-700 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></td>
          <td class="col-featured"><svg class="w-5 h-5 text-emerald-400 mx-auto" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg></td>
          <td><svg class="w-5 h-5 text-emerald-400 mx-auto" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg></td>
        </tr>
        <tr>
          <td class="px-6">Accès anticipé (beta)</td>
          <td><svg class="w-5 h-5 text-slate-700 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></td>
          <td class="col-featured"><svg class="w-5 h-5 text-emerald-400 mx-auto" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg></td>
          <td><svg class="w-5 h-5 text-emerald-400 mx-auto" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg></td>
        </tr>
        <tr>
          <td class="px-6">Support VIP dédié</td>
          <td><svg class="w-5 h-5 text-slate-700 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></td>
          <td class="col-featured"><svg class="w-5 h-5 text-slate-700 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></td>
          <td><svg class="w-5 h-5 text-emerald-400 mx-auto" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg></td>
        </tr>
        <!-- CTA row -->
        <tr>
          <td class="px-6 py-5"></td>
          <td class="py-5">
            <button class="btn-outline text-slate-300 text-xs px-4 py-2 rounded-lg font-medium w-full" onclick="showToast('Compte créé !','Bienvenue sur PixelVault 🎉')">Démarrer</button>
          </td>
          <td class="col-featured py-5">
            <button class="btn-primary text-white text-xs px-4 py-2 rounded-lg font-medium w-full" onclick="showToast('Essai Pro activé ! 🚀','14 jours gratuits')">Choisir Pro</button>
          </td>
          <td class="py-5">
            <button class="text-xs px-4 py-2 rounded-lg font-medium w-full border border-amber-500/35 text-amber-300 hover:bg-amber-500/10 transition-all" onclick="showToast('Candidature envoyée !','Sous 24h nous revenons vers vous')">Devenir créateur</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</section>

<!-- ===== TESTIMONIALS ===== -->
<section class="max-w-7xl mx-auto px-6 mb-24">
  <div class="text-center mb-12">
    <div class="text-violet-400 text-sm font-medium mb-2">Ils nous font confiance</div>
    <h2 class="font-display text-3xl md:text-4xl font-700 text-white">Ce que disent nos <span class="grad-text">abonnés Pro</span></h2>
  </div>
  <div class="grid md:grid-cols-3 gap-5">
    <div class="testi-card p-6">
      <div class="stars text-sm mb-3">★★★★★</div>
      <p class="text-slate-300 text-sm leading-relaxed mb-5">"Le plan Pro a complètement transformé ma façon de travailler. J'accède à tous les produits dont j'ai besoin sans me soucier du budget. ROI immédiat !"</p>
      <div class="flex items-center gap-3">
        <div class="w-9 h-9 rounded-full bg-linear-to-br from-violet-500 to-cyan-400 flex items-center justify-center text-white text-sm font-700 shrink-0">S</div>
        <div>
          <div class="text-white text-sm font-600">Sophie M.</div>
          <div class="text-slate-500 text-xs">UI Designer Freelance · Plan Pro</div>
        </div>
        <div class="ml-auto"><span class="savings-pill text-xs">Pro</span></div>
      </div>
    </div>
    <div class="testi-card p-6">
      <div class="stars text-sm mb-3">★★★★★</div>
      <p class="text-slate-300 text-sm leading-relaxed mb-5">"En tant que créateur, je génère plus de 3 000€/mois grâce à mes produits. La commission 70% et les outils analytics sont vraiment au top."</p>
      <div class="flex items-center gap-3">
        <div class="w-9 h-9 rounded-full bg-linear-to-br from-amber-500 to-orange-400 flex items-center justify-center text-white text-sm font-700 shrink-0">M</div>
        <div>
          <div class="text-white text-sm font-600">Marcus C.</div>
          <div class="text-slate-500 text-xs">Motion Designer · Plan Créateur</div>
        </div>
        <div class="ml-auto"><span class="text-xs px-2.5 py-1 rounded-full border border-amber-500/30 text-amber-400 bg-amber-500/10">Créateur</span></div>
      </div>
    </div>
    <div class="testi-card p-6">
      <div class="stars text-sm mb-3">★★★★★</div>
      <p class="text-slate-300 text-sm leading-relaxed mb-5">"J'ai commencé avec le plan gratuit et migré vers Pro en moins d'une semaine. La qualité des ressources justifie largement l'abonnement."</p>
      <div class="flex items-center gap-3">
        <div class="w-9 h-9 rounded-full bg-linear-to-br from-emerald-500 to-teal-400 flex items-center justify-center text-white text-sm font-700 shrink-0">K</div>
        <div>
          <div class="text-white text-sm font-600">Karim B.</div>
          <div class="text-slate-500 text-xs">Dev Full Stack · Plan Pro</div>
        </div>
        <div class="ml-auto"><span class="savings-pill text-xs">Pro</span></div>
      </div>
    </div>
  </div>
</section>

<!-- ===== FAQ ===== -->
<section class="max-w-3xl mx-auto px-6 mb-24">
  <div class="text-center mb-10">
    <div class="text-violet-400 text-sm font-medium mb-2">FAQ</div>
    <h2 class="font-display text-3xl md:text-4xl font-700 text-white">Questions <span class="grad-text">fréquentes</span></h2>
  </div>

  <div class="space-y-3" id="faqList">

    <div class="faq-item open">
      <button class="faq-trigger" onclick="toggleFaq(this)">
        <span class="text-white text-sm font-600">Puis-je changer de plan à tout moment ?</span>
        <div class="faq-chevron"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg></div>
      </button>
      <div class="faq-body">
        <p class="text-slate-400 text-sm leading-relaxed">Oui, absolument. Vous pouvez upgrader ou downgrader votre plan à tout moment depuis votre espace personnel. Les changements prennent effet immédiatement, et le montant est calculé au prorata de la période restante.</p>
      </div>
    </div>

    <div class="faq-item">
      <button class="faq-trigger" onclick="toggleFaq(this)">
        <span class="text-white text-sm font-600">Que se passe-t-il si j'annule mon abonnement ?</span>
        <div class="faq-chevron"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg></div>
      </button>
      <div class="faq-body">
        <p class="text-slate-400 text-sm leading-relaxed">Vous gardez accès à votre plan jusqu'à la fin de la période de facturation en cours. Après annulation, votre compte passe automatiquement au plan Starter gratuit. Vous conservez tous vos fichiers téléchargés précédemment.</p>
      </div>
    </div>

    <div class="faq-item">
      <button class="faq-trigger" onclick="toggleFaq(this)">
        <span class="text-white text-sm font-600">La licence commerciale couvre-t-elle tous les usages ?</span>
        <div class="faq-chevron"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg></div>
      </button>
      <div class="faq-body">
        <p class="text-slate-400 text-sm leading-relaxed">La licence commerciale du plan Pro vous permet d'utiliser les ressources dans des projets clients, des applications commerciales et des produits vendus, sans restriction de revenus. Elle ne permet pas la revente directe des fichiers sources. Le plan Créateur inclut des droits de revente supplémentaires.</p>
      </div>
    </div>

    <div class="faq-item">
      <button class="faq-trigger" onclick="toggleFaq(this)">
        <span class="text-white text-sm font-600">Comment fonctionne l'essai gratuit de 14 jours ?</span>
        <div class="faq-chevron"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg></div>
      </button>
      <div class="faq-body">
        <p class="text-slate-400 text-sm leading-relaxed">Pendant 14 jours, vous bénéficiez de toutes les fonctionnalités du plan Pro sans restriction. Aucune carte bancaire n'est requise pour démarrer. À la fin de l'essai, vous choisissez de continuer en souscrivant ou votre compte repasse automatiquement en Starter.</p>
      </div>
    </div>

    <div class="faq-item">
      <button class="faq-trigger" onclick="toggleFaq(this)">
        <span class="text-white text-sm font-600">Quels moyens de paiement acceptez-vous ?</span>
        <div class="faq-chevron"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg></div>
      </button>
      <div class="faq-body">
        <p class="text-slate-400 text-sm leading-relaxed">Nous acceptons toutes les cartes bancaires (Visa, Mastercard, American Express), PayPal, et les virements SEPA pour les abonnements annuels. Tous les paiements sont traités de façon sécurisée via Stripe.</p>
      </div>
    </div>

    <div class="faq-item">
      <button class="faq-trigger" onclick="toggleFaq(this)">
        <span class="text-white text-sm font-600">Comment devenir créateur sur PixelVault ?</span>
        <div class="faq-chevron"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg></div>
      </button>
      <div class="faq-body">
        <p class="text-slate-400 text-sm leading-relaxed">Pour rejoindre notre programme créateurs, cliquez sur "Devenir créateur", remplissez le formulaire de candidature avec des exemples de vos travaux. Notre équipe de curation examine chaque candidature sous 24-48h. Si accepté, vous accédez directement au plan Créateur avec toutes ses fonctionnalités.</p>
      </div>
    </div>

    <div class="faq-item">
      <button class="faq-trigger" onclick="toggleFaq(this)">
        <span class="text-white text-sm font-600">Proposez-vous des tarifs pour les équipes et entreprises ?</span>
        <div class="faq-chevron"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg></div>
      </button>
      <div class="faq-body">
        <p class="text-slate-400 text-sm leading-relaxed">Oui ! Nous proposons des offres sur-mesure pour les équipes de 5 personnes et plus, avec gestion centralisée des licences, facturation unique et options de SSO. Contactez notre équipe commerciale via le formulaire de contact pour un devis personnalisé.</p>
      </div>
    </div>

  </div>
</section>

<!-- ===== FINAL CTA ===== -->
<section class="max-w-7xl mx-auto px-6 pb-24">
  <div class="relative rounded-3xl overflow-hidden">
    <div class="absolute inset-0 bg-linear-to-br from-violet-900/70 to-cyan-900/30"></div>
    <div class="absolute inset-0" style="background-image:linear-gradient(rgba(124,58,237,.04) 1px,transparent 1px),linear-gradient(90deg,rgba(124,58,237,.04) 1px,transparent 1px);background-size:40px 40px;opacity:.6;"></div>
    <div class="orb" style="width:400px;height:400px;background:rgba(124,58,237,.2);top:-150px;left:-100px;filter:blur(60px);"></div>
    <div class="orb" style="width:300px;height:300px;background:rgba(6,182,212,.15);bottom:-100px;right:-80px;filter:blur(60px);"></div>

    <div class="relative z-10 text-center py-20 px-6">
      <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full border border-violet-500/30 bg-violet-500/10 text-violet-300 text-xs font-medium mb-6">
        🎁 Aucune carte bancaire requise pour commencer
      </div>
      <h2 class="font-display text-4xl md:text-6xl font-800 text-white mb-6 leading-tight">
        Prêt à passer au<br/><span class="grad-text">niveau supérieur ?</span>
      </h2>
      <p class="text-slate-300 text-lg max-w-xl mx-auto mb-10 leading-relaxed">
        Rejoignez 12 000+ créatifs qui font confiance à PixelVault. Démarrez gratuitement et upgradez quand vous êtes prêt.
      </p>
      <div class="flex flex-col sm:flex-row gap-4 justify-center">
        <button class="btn-primary text-white px-10 py-4 rounded-xl font-medium text-base flex items-center gap-2 justify-center" onclick="showToast('Essai Pro activé ! 🚀','14 jours gratuits, sans engagement')">
          Démarrer l'essai gratuit Pro
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
        </button>
        <a href="explorer.html" class="btn-outline text-white px-10 py-4 rounded-xl font-medium text-base border-white/20 flex items-center gap-2 justify-center">
          Explorer les produits
        </a>
      </div>

      <!-- Logos / Trust badges -->
      <div class="flex flex-wrap items-center justify-center gap-8 mt-14 opacity-40">
        <div class="text-slate-400 text-xs uppercase tracking-widest font-medium">Ils nous font confiance :</div>
        <div class="text-slate-300 font-display font-700 text-base">Stripe</div>
        <div class="text-slate-300 font-display font-700 text-base">Figma</div>
        <div class="text-slate-300 font-display font-700 text-base">Notion</div>
        <div class="text-slate-300 font-display font-700 text-base">Framer</div>
        <div class="text-slate-300 font-display font-700 text-base">Webflow</div>
      </div>
    </div>
  </div>
</section>

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
/* ─── CURSOR ─── */
const cursorEl = document.getElementById('cursor');
const ringEl   = document.getElementById('cursorRing');
let mx=0,my=0,rx=0,ry=0;
document.addEventListener('mousemove', e => { mx=e.clientX; my=e.clientY; cursorEl.style.left=mx+'px'; cursorEl.style.top=my+'px'; });
(function animRing(){ rx+=(mx-rx)*.12; ry+=(my-ry)*.12; ringEl.style.left=rx+'px'; ringEl.style.top=ry+'px'; requestAnimationFrame(animRing); })();
document.querySelectorAll('a,button,input,.faq-item,.pricing-card').forEach(el => {
  el.addEventListener('mouseenter',()=>{ cursorEl.style.width='20px'; cursorEl.style.height='20px'; ringEl.style.width='50px'; ringEl.style.height='50px'; });
  el.addEventListener('mouseleave',()=>{ cursorEl.style.width='12px'; cursorEl.style.height='12px'; ringEl.style.width='36px'; ringEl.style.height='36px'; });
});

/* ─── TOAST ─── */
function showToast(msg, sub) {
  document.getElementById('toastMsg').textContent = msg;
  document.getElementById('toastSub').textContent = sub || 'PixelVault';
  const t = document.getElementById('toast');
  t.classList.add('show');
  setTimeout(() => t.classList.remove('show'), 3200);
}

/* ─── BILLING TOGGLE ─── */
let billing = 'monthly';
const prices = {
  pro:     { monthly: '19€', annual: '13€',  subMonthly: 'Facturé 228€/an · Économisez 84€',  subAnnual: 'Facturé 156€/an · Économisez 72€' },
  creator: { monthly: '49€', annual: '34€', subMonthly: 'Facturé 588€/an · Économisez 216€', subAnnual: 'Facturé 408€/an · Économisez 180€' },
};

function setBilling(mode) {
  billing = mode;
  const monthly = mode === 'monthly';
  const slider = document.getElementById('toggleSlider');
  const btnM   = document.getElementById('btnMonthly');
  const btnA   = document.getElementById('btnAnnual');

  // Move slider
  if (monthly) {
    slider.style.width  = btnM.offsetWidth + 'px';
    slider.style.left   = '4px';
  } else {
    slider.style.width  = btnA.offsetWidth + 'px';
    slider.style.left   = (btnM.offsetWidth + 4) + 'px';
  }
  btnM.classList.toggle('active', monthly);
  btnA.classList.toggle('active', !monthly);

  // Update Pro
  const proEl = document.getElementById('proPriceMonthly');
  proEl.style.animation = 'none'; proEl.offsetHeight;
  proEl.style.animation = 'priceFlip .3s ease forwards';
  proEl.textContent = monthly ? prices.pro.monthly : prices.pro.annual;
  document.getElementById('proPricePeriod').textContent = monthly ? '/mois' : '/mois*';
  document.getElementById('proPriceSub').textContent    = monthly ? prices.pro.subMonthly : prices.pro.subAnnual;

  // Update Creator
  const creEl = document.getElementById('creatorPriceMonthly');
  creEl.style.animation = 'none'; creEl.offsetHeight;
  creEl.style.animation = 'priceFlip .3s ease forwards';
  creEl.textContent = monthly ? prices.creator.monthly : prices.creator.annual;
  document.getElementById('creatorPricePeriod').textContent = monthly ? '/mois' : '/mois*';
  document.getElementById('creatorPriceSub').textContent    = monthly ? prices.creator.subMonthly : prices.creator.subAnnual;
}

// Init slider width
window.addEventListener('load', () => {
  const btn = document.getElementById('btnMonthly');
  document.getElementById('toggleSlider').style.width = btn.offsetWidth + 'px';
});

/* ─── FAQ ACCORDION ─── */
function toggleFaq(trigger) {
  const item = trigger.closest('.faq-item');
  const isOpen = item.classList.contains('open');

  // Close all
  document.querySelectorAll('.faq-item.open').forEach(i => i.classList.remove('open'));

  // Open clicked if it was closed
  if (!isOpen) item.classList.add('open');
}

/* ─── SCROLL ANIMATIONS ─── */
const io = new IntersectionObserver(entries => {
  entries.forEach(e => {
    if (e.isIntersecting) {
      e.target.style.animation = 'fadeUp .6s ease forwards';
      io.unobserve(e.target);
    }
  });
}, { threshold: .1 });

document.querySelectorAll('.testi-card, .faq-item, .comp-wrapper, .stat-num').forEach((el, i) => {
  el.style.opacity = '0';
  el.style.animationDelay = (i * .06) + 's';
  io.observe(el);
});
</script>
</body>
</html>
