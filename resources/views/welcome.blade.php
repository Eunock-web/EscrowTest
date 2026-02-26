<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>PixelVault — Produits Digitaux Premium</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,300&display=swap"
        rel="stylesheet" />
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

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            background-color: var(--c-bg);
            color: var(--c-text);
            font-family: 'DM Sans', sans-serif;
            overflow-x: hidden;
            cursor: none;
        }

        /* Custom cursor */
        .cursor {
            width: 12px;
            height: 12px;
            background: var(--c-accent2);
            border-radius: 50%;
            position: fixed;
            pointer-events: none;
            z-index: 9999;
            transform: translate(-50%, -50%);
            transition: transform 0.1s ease, width 0.2s, height 0.2s, background 0.2s;
            mix-blend-mode: screen;
        }

        .cursor-ring {
            width: 36px;
            height: 36px;
            border: 1.5px solid rgba(124, 58, 237, 0.5);
            border-radius: 50%;
            position: fixed;
            pointer-events: none;
            z-index: 9998;
            transform: translate(-50%, -50%);
            transition: transform 0.18s ease, width 0.3s, height 0.3s, opacity 0.3s;
        }

        body:hover .cursor {
            opacity: 1;
        }

        /* Fonts */
        h1,
        h2,
        h3,
        h4,
        .font-display {
            font-family: 'Syne', sans-serif;
        }

        /* Noise overlay */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.03'/%3E%3C/svg%3E");
            pointer-events: none;
            z-index: 1000;
            opacity: 0.4;
        }

        /* Grid bg */
        .grid-bg {
            background-image:
                linear-gradient(rgba(124, 58, 237, 0.04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(124, 58, 237, 0.04) 1px, transparent 1px);
            background-size: 60px 60px;
        }

        /* Glow orbs */
        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            pointer-events: none;
        }

        .orb-1 {
            width: 600px;
            height: 600px;
            background: rgba(124, 58, 237, 0.15);
            top: -200px;
            left: -100px;
        }

        .orb-2 {
            width: 400px;
            height: 400px;
            background: rgba(6, 182, 212, 0.1);
            top: 200px;
            right: -150px;
        }

        .orb-3 {
            width: 300px;
            height: 300px;
            background: rgba(245, 158, 11, 0.07);
            bottom: 100px;
            left: 50%;
        }

        /* Animations */
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-12px);
            }
        }

        @keyframes pulse-ring {
            0% {
                transform: scale(1);
                opacity: 0.6;
            }

            100% {
                transform: scale(1.8);
                opacity: 0;
            }
        }

        @keyframes spin-slow {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        @keyframes shimmer {
            0% {
                background-position: -200% 0;
            }

            100% {
                background-position: 200% 0;
            }
        }

        @keyframes ticker {
            from {
                transform: translateX(0);
            }

            to {
                transform: translateX(-50%);
            }
        }

        @keyframes blink {

            0%,
            100% {
                opacity: 1
            }

            50% {
                opacity: 0
            }
        }

        .anim-fade-up {
            animation: fadeUp 0.7s ease forwards;
        }

        .anim-float {
            animation: float 4s ease-in-out infinite;
        }

        .delay-1 {
            animation-delay: 0.1s;
            opacity: 0;
        }

        .delay-2 {
            animation-delay: 0.25s;
            opacity: 0;
        }

        .delay-3 {
            animation-delay: 0.4s;
            opacity: 0;
        }

        .delay-4 {
            animation-delay: 0.6s;
            opacity: 0;
        }

        .delay-5 {
            animation-delay: 0.8s;
            opacity: 0;
        }

        /* Shimmer button */
        .btn-primary {
            background: linear-gradient(135deg, #7c3aed, #5b21b6);
            position: relative;
            overflow: hidden;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .btn-primary::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(105deg, transparent 40%, rgba(255, 255, 255, 0.15) 50%, transparent 60%);
            background-size: 200% 100%;
            animation: shimmer 2.5s infinite;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 0 30px rgba(124, 58, 237, 0.5);
        }

        .btn-outline {
            border: 1px solid rgba(124, 58, 237, 0.5);
            transition: all 0.2s;
            background: transparent;
        }

        .btn-outline:hover {
            border-color: var(--c-accent2);
            background: rgba(6, 182, 212, 0.08);
            box-shadow: 0 0 20px rgba(6, 182, 212, 0.2);
        }

        /* Card */
        .product-card {
            background: var(--c-surface);
            border: 1px solid var(--c-border);
            transition: transform 0.3s ease, border-color 0.3s, box-shadow 0.3s;
            position: relative;
            overflow: hidden;
        }

        .product-card::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(124, 58, 237, 0.06), rgba(6, 182, 212, 0.04));
            opacity: 0;
            transition: opacity 0.3s;
        }

        .product-card:hover {
            transform: translateY(-6px);
            border-color: rgba(124, 58, 237, 0.4);
            box-shadow: 0 20px 60px rgba(124, 58, 237, 0.15);
        }

        .product-card:hover::before {
            opacity: 1;
        }

        /* Badge glow */
        .badge-glow {
            animation: pulse-ring 1.8s ease-out infinite;
            position: absolute;
            inset: 0;
            border-radius: inherit;
            border: 1px solid var(--c-accent);
        }

        /* Ticker */
        .ticker-wrap {
            overflow: hidden;
        }

        .ticker-track {
            display: flex;
            animation: ticker 25s linear infinite;
            white-space: nowrap;
        }

        .ticker-track:hover {
            animation-play-state: paused;
        }

        /* Nav blur */
        nav {
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
        }

        /* Stat highlight */
        .stat-num {
            font-family: 'Syne', sans-serif;
            font-size: 2.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, #a78bfa, #22d3ee);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Feature icon ring */
        .icon-ring {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .icon-ring::before {
            content: '';
            position: absolute;
            inset: -8px;
            border-radius: 50%;
            border: 1px dashed rgba(124, 58, 237, 0.3);
            animation: spin-slow 12s linear infinite;
        }

        /* Gradient text */
        .grad-text {
            background: linear-gradient(135deg, #a78bfa 0%, #22d3ee 50%, #f59e0b 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: var(--c-bg);
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(124, 58, 237, 0.4);
            border-radius: 3px;
        }

        /* Category pill */
        .cat-pill {
            border: 1px solid var(--c-border);
            transition: all 0.2s;
            cursor: pointer;
        }

        .cat-pill:hover,
        .cat-pill.active {
            border-color: var(--c-accent);
            background: rgba(124, 58, 237, 0.15);
            color: #a78bfa;
        }

        /* Star rating */
        .stars {
            color: var(--c-gold);
        }

        /* Testimonial card */
        .testi-card {
            background: linear-gradient(135deg, rgba(124, 58, 237, 0.08), rgba(6, 182, 212, 0.04));
            border: 1px solid rgba(124, 58, 237, 0.2);
            transition: border-color 0.3s;
        }

        .testi-card:hover {
            border-color: rgba(124, 58, 237, 0.5);
        }
    </style>
</head>

<body class="grid-bg">

    <!-- Custom Cursor -->
    <div class="cursor" id="cursor"></div>
    <div class="cursor-ring" id="cursorRing"></div>

    <!-- ===== NAV ===== -->
    <nav class="fixed top-0 inset-x-0 z-50 border-b border-white/5 bg-[#09090f]/80">
        <div class="max-w-7xl mx-auto px-6 h-16 flex items-center justify-between">
            <!-- Logo -->
            <div class="flex items-center gap-2">
                <div
                    class="w-8 h-8 rounded-lg bg-linear-to-br from-violet-600 to-cyan-500 flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z" />
                    </svg>
                </div>
                <span class="font-display text-lg font-700 text-white tracking-tight">Pixel<span
                        class="grad-text">Vault</span></span>
            </div>

            <!-- Links -->
            <div class="hidden md:flex items-center gap-8 text-sm text-slate-400">
                <a href="/explorer" class="hover:text-white transition-colors">Explorer</a>
                <a href="#" class="hover:text-white transition-colors">Catégories</a>
                <a href="/createurs" class="hover:text-white transition-colors">Créateurs</a>
                <a href="/tarifs" class="hover:text-white transition-colors">Tarifs</a>
            </div>

            <!-- Actions -->
            <div class="flex items-center gap-3">
                <a href="/auth/login"> <button
                        class="hidden sm:block text-sm text-slate-400 hover:text-white transition-colors px-4 py-2">Connexion</button>
                </a>
                <button class="btn-primary text-sm text-white px-5 py-2 rounded-lg font-medium">Commencer</button>
            </div>
        </div>
    </nav>

    <!-- ===== HERO ===== -->
    <section class="relative min-h-screen flex items-center overflow-hidden pt-16">
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
        <div class="orb orb-3"></div>

        <div class="max-w-7xl mx-auto px-6 py-24 w-full">
            <div class="grid lg:grid-cols-2 gap-16 items-center">

                <!-- Left -->
                <div>
                    <!-- Badge -->
                    <div
                        class="anim-fade-up delay-1 inline-flex items-center gap-2 px-3 py-1.5 rounded-full border border-violet-500/30 bg-violet-500/10 text-violet-300 text-xs font-medium mb-8">
                        <span class="relative flex h-2 w-2">
                            <span class="badge-glow rounded-full"></span>
                            <span class="h-2 w-2 rounded-full bg-violet-400"></span>
                        </span>
                        +2 400 produits digitaux disponibles dès maintenant
                    </div>

                    <h1
                        class="anim-fade-up delay-2 text-5xl lg:text-7xl font-800 leading-[0.95] tracking-tight text-white mb-6">
                        La marketplace<br />
                        du <span class="grad-text">digital</span><br />
                        premium.
                    </h1>

                    <p class="anim-fade-up delay-3 text-slate-400 text-lg max-w-md mb-10 leading-relaxed">
                        Templates, UI Kits, cours en ligne, plugins et plus encore — créés par des designers et
                        développeurs d'exception, pour des résultats d'exception.
                    </p>

                    <div class="anim-fade-up delay-4 flex flex-col sm:flex-row gap-4 mb-14">
                        <button
                            class="btn-primary text-white px-8 py-3.5 rounded-xl font-medium text-base flex items-center gap-2 justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                            Explorer la boutique
                        </button>
                        <button
                            class="btn-outline text-slate-300 px-8 py-3.5 rounded-xl font-medium text-base flex items-center gap-2 justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Voir la démo
                        </button>
                    </div>

                    <!-- Stats -->
                    <div class="anim-fade-up delay-5 flex items-center gap-8 pt-6 border-t border-white/5">
                        <div>
                            <div class="stat-num">12k+</div>
                            <div class="text-slate-500 text-xs mt-0.5">Clients satisfaits</div>
                        </div>
                        <div class="w-px h-10 bg-white/5"></div>
                        <div>
                            <div class="stat-num">2.4k</div>
                            <div class="text-slate-500 text-xs mt-0.5">Produits premium</div>
                        </div>
                        <div class="w-px h-10 bg-white/5"></div>
                        <div>
                            <div class="stat-num">98%</div>
                            <div class="text-slate-500 text-xs mt-0.5">Taux de satisfaction</div>
                        </div>
                    </div>
                </div>

                <!-- Right – floating cards -->
                <div class="relative h-130 hidden lg:block">
                    <!-- Main card -->
                    <div class="anim-float absolute top-8 right-0 w-72 product-card rounded-2xl p-5 shadow-2xl">
                        <div
                            class="h-40 rounded-xl bg-linear-to-br from-violet-600/30 to-cyan-500/20 mb-4 flex items-center justify-center relative overflow-hidden">
                            <div class="absolute inset-0"
                                style="background: radial-gradient(ellipse at 30% 50%, rgba(124,58,237,0.4), transparent 70%)">
                            </div>
                            <svg class="w-12 h-12 text-violet-400 relative z-10" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <div
                                class="absolute top-2 right-2 bg-violet-500 text-white text-xs px-2 py-0.5 rounded-full font-medium">
                                Bestseller</div>
                        </div>
                        <div class="text-xs text-cyan-400 font-medium mb-1">UI KIT</div>
                        <div class="font-display text-white font-600 mb-2">Dashboard Pro Suite</div>
                        <div class="flex items-center justify-between">
                            <div class="stars text-sm">★★★★★ <span class="text-slate-400 ml-1">4.9</span></div>
                            <div class="text-white font-700 text-lg">49€</div>
                        </div>
                    </div>

                    <!-- Secondary card -->
                    <div class="anim-float absolute bottom-20 left-0 w-60 product-card rounded-2xl p-4 shadow-xl"
                        style="animation-delay: 1.2s">
                        <div
                            class="h-28 rounded-lg bg-gradient-to-br from-amber-500/20 to-rose-500/20 mb-3 flex items-center justify-center">
                            <svg class="w-10 h-10 text-amber-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <div class="text-xs text-amber-400 font-medium mb-0.5">COURS</div>
                        <div class="font-display text-white text-sm font-600 mb-1">Maîtrise Figma 2024</div>
                        <div class="text-violet-400 font-700">29€</div>
                    </div>

                    <!-- Notification -->
                    <div class="absolute top-[45%] right-[-20px] bg-[#111118] border border-white/10 rounded-xl px-4 py-3 flex items-center gap-3 w-52 shadow-xl"
                        style="animation: float 3s ease-in-out infinite; animation-delay: 0.5s">
                        <div
                            class="w-8 h-8 rounded-full bg-gradient-to-br from-emerald-400 to-cyan-500 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <div>
                            <div class="text-white text-xs font-medium">Achat confirmé</div>
                            <div class="text-slate-500 text-xs">Téléchargement prêt ✨</div>
                        </div>
                    </div>

                    <!-- Tag -->
                    <div
                        class="absolute bottom-8 right-8 bg-gradient-to-r from-violet-600 to-cyan-500 p-px rounded-xl">
                        <div class="bg-[#09090f] rounded-xl px-4 py-2.5">
                            <div class="text-xs text-slate-400">Accès immédiat</div>
                            <div class="text-white text-sm font-600 font-display">Livraison instantanée</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== TICKER ===== -->
    <div class="ticker-wrap py-4 border-y border-white/5 bg-black/20">
        <div class="ticker-track gap-12 text-slate-500 text-sm font-medium">
            <span class="px-8">⚡ Templates Figma</span>
            <span class="px-8">🎨 UI Kits Premium</span>
            <span class="px-8">📦 Composants React</span>
            <span class="px-8">🔌 Plugins WordPress</span>
            <span class="px-8">📚 Cours & Formations</span>
            <span class="px-8">🎵 Assets Audio</span>
            <span class="px-8">🖼 Illustrations SVG</span>
            <span class="px-8">⚙️ Scripts & Outils</span>
            <span class="px-8">⚡ Templates Figma</span>
            <span class="px-8">🎨 UI Kits Premium</span>
            <span class="px-8">📦 Composants React</span>
            <span class="px-8">🔌 Plugins WordPress</span>
            <span class="px-8">📚 Cours & Formations</span>
            <span class="px-8">🎵 Assets Audio</span>
            <span class="px-8">🖼 Illustrations SVG</span>
            <span class="px-8">⚙️ Scripts & Outils</span>
        </div>
    </div>

    <!-- ===== CATEGORIES ===== -->
    <section class="max-w-7xl mx-auto px-6 py-20">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 gap-4">
            <div>
                <div class="text-violet-400 text-sm font-medium mb-2">Parcourir</div>
                <h2 class="font-display text-3xl md:text-4xl font-700 text-white">Catégories <span
                        class="grad-text">populaires</span></h2>
            </div>
            <a href="#"
                class="text-sm text-cyan-400 hover:text-cyan-300 transition-colors flex items-center gap-1">
                Tout voir <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>

        <div class="flex flex-wrap gap-3 mb-4" id="catFilter">
            <button class="cat-pill active text-sm px-4 py-2 rounded-full text-slate-400">Tout</button>
            <button class="cat-pill text-sm px-4 py-2 rounded-full text-slate-400">UI Kits</button>
            <button class="cat-pill text-sm px-4 py-2 rounded-full text-slate-400">Templates</button>
            <button class="cat-pill text-sm px-4 py-2 rounded-full text-slate-400">Cours</button>
            <button class="cat-pill text-sm px-4 py-2 rounded-full text-slate-400">Plugins</button>
            <button class="cat-pill text-sm px-4 py-2 rounded-full text-slate-400">Illustrations</button>
            <button class="cat-pill text-sm px-4 py-2 rounded-full text-slate-400">Audio</button>
        </div>
    </section>

    <!-- ===== PRODUCTS ===== -->
    <section class="max-w-7xl mx-auto px-6 pb-20">
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">

            <!-- Card 1 -->
            <div class="product-card rounded-2xl overflow-hidden group">
                <div
                    class="h-44 bg-gradient-to-br from-violet-600/30 via-purple-900/30 to-black relative overflow-hidden">
                    <div class="absolute inset-0 flex items-center justify-center">
                        <svg class="w-14 h-14 text-violet-400 group-hover:scale-110 transition-transform duration-300"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" />
                        </svg>
                    </div>
                    <div
                        class="absolute top-3 left-3 bg-violet-500/90 text-white text-xs px-2 py-1 rounded-lg font-medium backdrop-blur">
                        Nouveau</div>
                    <div class="absolute top-3 right-3 opacity-0 group-hover:opacity-100 transition-opacity">
                        <button
                            class="w-8 h-8 bg-white/10 hover:bg-white/20 rounded-lg flex items-center justify-center backdrop-blur transition-colors">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="p-4">
                    <div class="text-xs text-violet-400 font-medium mb-1">UI KIT</div>
                    <h3 class="font-display text-white font-600 text-sm mb-1">SaaS Dashboard Pro</h3>
                    <div class="flex items-center gap-1 text-xs text-slate-500 mb-3">
                        <div class="stars text-xs">★★★★★</div>
                        <span>4.9 (312)</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div>
                            <span class="text-white font-700 text-lg">49€</span>
                            <span class="text-slate-600 text-xs line-through ml-1">89€</span>
                        </div>
                        <button
                            class="btn-primary text-white text-xs px-3 py-1.5 rounded-lg font-medium">Acheter</button>
                    </div>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="product-card rounded-2xl overflow-hidden group">
                <div class="h-44 bg-gradient-to-br from-cyan-600/30 via-teal-900/30 to-black relative overflow-hidden">
                    <div class="absolute inset-0 flex items-center justify-center">
                        <svg class="w-14 h-14 text-cyan-400 group-hover:scale-110 transition-transform duration-300"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <div class="absolute top-3 right-3 opacity-0 group-hover:opacity-100 transition-opacity">
                        <button
                            class="w-8 h-8 bg-white/10 hover:bg-white/20 rounded-lg flex items-center justify-center backdrop-blur transition-colors">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="p-4">
                    <div class="text-xs text-cyan-400 font-medium mb-1">COURS EN LIGNE</div>
                    <h3 class="font-display text-white font-600 text-sm mb-1">Masterclass Next.js 14</h3>
                    <div class="flex items-center gap-1 text-xs text-slate-500 mb-3">
                        <div class="stars text-xs">★★★★★</div>
                        <span>4.8 (198)</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div>
                            <span class="text-white font-700 text-lg">79€</span>
                        </div>
                        <button
                            class="btn-primary text-white text-xs px-3 py-1.5 rounded-lg font-medium">Acheter</button>
                    </div>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="product-card rounded-2xl overflow-hidden group">
                <div
                    class="h-44 bg-gradient-to-br from-amber-600/30 via-orange-900/30 to-black relative overflow-hidden">
                    <div class="absolute inset-0 flex items-center justify-center">
                        <svg class="w-14 h-14 text-amber-400 group-hover:scale-110 transition-transform duration-300"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                        </svg>
                    </div>
                    <div
                        class="absolute top-3 left-3 bg-amber-500/90 text-white text-xs px-2 py-1 rounded-lg font-medium backdrop-blur">
                        ⭐ Top rated</div>
                    <div class="absolute top-3 right-3 opacity-0 group-hover:opacity-100 transition-opacity">
                        <button
                            class="w-8 h-8 bg-white/10 hover:bg-white/20 rounded-lg flex items-center justify-center backdrop-blur transition-colors">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="p-4">
                    <div class="text-xs text-amber-400 font-medium mb-1">ILLUSTRATION</div>
                    <h3 class="font-display text-white font-600 text-sm mb-1">3D Icon Pack — 800 icônes</h3>
                    <div class="flex items-center gap-1 text-xs text-slate-500 mb-3">
                        <div class="stars text-xs">★★★★★</div>
                        <span>5.0 (87)</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div>
                            <span class="text-white font-700 text-lg">39€</span>
                            <span class="text-slate-600 text-xs line-through ml-1">59€</span>
                        </div>
                        <button
                            class="btn-primary text-white text-xs px-3 py-1.5 rounded-lg font-medium">Acheter</button>
                    </div>
                </div>
            </div>

            <!-- Card 4 -->
            <div class="product-card rounded-2xl overflow-hidden group">
                <div class="h-44 bg-gradient-to-br from-rose-600/30 via-pink-900/30 to-black relative overflow-hidden">
                    <div class="absolute inset-0 flex items-center justify-center">
                        <svg class="w-14 h-14 text-rose-400 group-hover:scale-110 transition-transform duration-300"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                        </svg>
                    </div>
                    <div class="absolute top-3 right-3 opacity-0 group-hover:opacity-100 transition-opacity">
                        <button
                            class="w-8 h-8 bg-white/10 hover:bg-white/20 rounded-lg flex items-center justify-center backdrop-blur transition-colors">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="p-4">
                    <div class="text-xs text-rose-400 font-medium mb-1">AUDIO</div>
                    <h3 class="font-display text-white font-600 text-sm mb-1">SFX Pack Vol.3 — UI Sounds</h3>
                    <div class="flex items-center gap-1 text-xs text-slate-500 mb-3">
                        <div class="stars text-xs">★★★★☆</div>
                        <span>4.7 (54)</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div>
                            <span class="text-white font-700 text-lg">19€</span>
                        </div>
                        <button
                            class="btn-primary text-white text-xs px-3 py-1.5 rounded-lg font-medium">Acheter</button>
                    </div>
                </div>
            </div>

            <!-- Card 5 -->
            <div class="product-card rounded-2xl overflow-hidden group">
                <div
                    class="h-44 bg-gradient-to-br from-emerald-600/30 via-green-900/30 to-black relative overflow-hidden">
                    <div class="absolute inset-0 flex items-center justify-center">
                        <svg class="w-14 h-14 text-emerald-400 group-hover:scale-110 transition-transform duration-300"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                        </svg>
                    </div>
                    <div
                        class="absolute top-3 left-3 bg-emerald-500/90 text-white text-xs px-2 py-1 rounded-lg font-medium backdrop-blur">
                        Gratuit</div>
                </div>
                <div class="p-4">
                    <div class="text-xs text-emerald-400 font-medium mb-1">TEMPLATE</div>
                    <h3 class="font-display text-white font-600 text-sm mb-1">Landing Page Starter Kit</h3>
                    <div class="flex items-center gap-1 text-xs text-slate-500 mb-3">
                        <div class="stars text-xs">★★★★★</div>
                        <span>4.6 (234)</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div>
                            <span class="text-emerald-400 font-700 text-lg">Gratuit</span>
                        </div>
                        <button
                            class="btn-outline text-slate-300 text-xs px-3 py-1.5 rounded-lg font-medium border-emerald-500/30 hover:border-emerald-400">Obtenir</button>
                    </div>
                </div>
            </div>

            <!-- Card 6 -->
            <div class="product-card rounded-2xl overflow-hidden group">
                <div class="h-44 bg-gradient-to-br from-sky-600/30 via-blue-900/30 to-black relative overflow-hidden">
                    <div class="absolute inset-0 flex items-center justify-center">
                        <svg class="w-14 h-14 text-sky-400 group-hover:scale-110 transition-transform duration-300"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <div
                        class="absolute top-3 left-3 bg-sky-500/90 text-white text-xs px-2 py-1 rounded-lg font-medium backdrop-blur">
                        Promo -40%</div>
                </div>
                <div class="p-4">
                    <div class="text-xs text-sky-400 font-medium mb-1">PLUGIN</div>
                    <h3 class="font-display text-white font-600 text-sm mb-1">Motion UI Library — Framer</h3>
                    <div class="flex items-center gap-1 text-xs text-slate-500 mb-3">
                        <div class="stars text-xs">★★★★★</div>
                        <span>4.9 (143)</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div>
                            <span class="text-white font-700 text-lg">29€</span>
                            <span class="text-slate-600 text-xs line-through ml-1">49€</span>
                        </div>
                        <button
                            class="btn-primary text-white text-xs px-3 py-1.5 rounded-lg font-medium">Acheter</button>
                    </div>
                </div>
            </div>

            <!-- Card 7 -->
            <div class="product-card rounded-2xl overflow-hidden group">
                <div
                    class="h-44 bg-gradient-to-br from-indigo-600/30 via-indigo-900/30 to-black relative overflow-hidden">
                    <div class="absolute inset-0 flex items-center justify-center">
                        <svg class="w-14 h-14 text-indigo-400 group-hover:scale-110 transition-transform duration-300"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                    </div>
                </div>
                <div class="p-4">
                    <div class="text-xs text-indigo-400 font-medium mb-1">BUNDLE</div>
                    <h3 class="font-display text-white font-600 text-sm mb-1">Design System Complet 2024</h3>
                    <div class="flex items-center gap-1 text-xs text-slate-500 mb-3">
                        <div class="stars text-xs">★★★★★</div>
                        <span>5.0 (67)</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div>
                            <span class="text-white font-700 text-lg">99€</span>
                            <span class="text-slate-600 text-xs line-through ml-1">199€</span>
                        </div>
                        <button
                            class="btn-primary text-white text-xs px-3 py-1.5 rounded-lg font-medium">Acheter</button>
                    </div>
                </div>
            </div>

            <!-- Card 8 -->
            <div class="product-card rounded-2xl overflow-hidden group">
                <div
                    class="h-44 bg-gradient-to-br from-fuchsia-600/30 via-fuchsia-900/30 to-black relative overflow-hidden">
                    <div class="absolute inset-0 flex items-center justify-center">
                        <svg class="w-14 h-14 text-fuchsia-400 group-hover:scale-110 transition-transform duration-300"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M15 10l4.553-2.069A1 1 0 0121 8.867v6.266a1 1 0 01-1.447.902L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div
                        class="absolute top-3 left-3 bg-fuchsia-500/90 text-white text-xs px-2 py-1 rounded-lg font-medium backdrop-blur">
                        Tendance</div>
                </div>
                <div class="p-4">
                    <div class="text-xs text-fuchsia-400 font-medium mb-1">TEMPLATES VIDÉO</div>
                    <h3 class="font-display text-white font-600 text-sm mb-1">After Effects Intro Pack</h3>
                    <div class="flex items-center gap-1 text-xs text-slate-500 mb-3">
                        <div class="stars text-xs">★★★★☆</div>
                        <span>4.5 (89)</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div>
                            <span class="text-white font-700 text-lg">34€</span>
                        </div>
                        <button
                            class="btn-primary text-white text-xs px-3 py-1.5 rounded-lg font-medium">Acheter</button>
                    </div>
                </div>
            </div>

        </div>

        <div class="text-center mt-10">
            <button class="btn-outline text-slate-300 px-8 py-3 rounded-xl font-medium text-sm border-white/10">
                Charger plus de produits →
            </button>
        </div>
    </section>

    <!-- ===== FEATURES ===== -->
    <section class="relative py-24 overflow-hidden">
        <div
            class="absolute inset-0 bg-gradient-to-b from-transparent via-violet-950/10 to-transparent pointer-events-none">
        </div>
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <div class="text-violet-400 text-sm font-medium mb-3">Pourquoi PixelVault</div>
                <h2 class="font-display text-3xl md:text-5xl font-700 text-white">Tout ce dont vous <span
                        class="grad-text">avez besoin</span></h2>
            </div>

            <div class="grid md:grid-cols-3 gap-6">
                <div
                    class="p-6 rounded-2xl bg-gradient-to-br from-violet-500/10 to-transparent border border-violet-500/20 hover:border-violet-500/40 transition-all duration-300 group">
                    <div class="icon-ring w-12 h-12 rounded-xl bg-violet-500/20 mb-5">
                        <svg class="w-5 h-5 text-violet-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h3 class="font-display text-white font-700 text-lg mb-2">Téléchargement instantané</h3>
                    <p class="text-slate-400 text-sm leading-relaxed">Accédez à vos fichiers immédiatement après votre
                        achat. Pas d'attente, pas de friction.</p>
                </div>

                <div
                    class="p-6 rounded-2xl bg-gradient-to-br from-cyan-500/10 to-transparent border border-cyan-500/20 hover:border-cyan-500/40 transition-all duration-300 group">
                    <div class="icon-ring w-12 h-12 rounded-xl bg-cyan-500/20 mb-5"
                        style="--ring-color: rgba(6,182,212,0.3)">
                        <svg class="w-5 h-5 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <h3 class="font-display text-white font-700 text-lg mb-2">Paiements 100% sécurisés</h3>
                    <p class="text-slate-400 text-sm leading-relaxed">Vos transactions sont protégées par un
                        chiffrement de niveau bancaire et Stripe.</p>
                </div>

                <div
                    class="p-6 rounded-2xl bg-gradient-to-br from-amber-500/10 to-transparent border border-amber-500/20 hover:border-amber-500/40 transition-all duration-300 group">
                    <div class="icon-ring w-12 h-12 rounded-xl bg-amber-500/20 mb-5">
                        <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                        </svg>
                    </div>
                    <h3 class="font-display text-white font-700 text-lg mb-2">Produits vérifiés</h3>
                    <p class="text-slate-400 text-sm leading-relaxed">Chaque produit est contrôlé par notre équipe
                        avant publication. Qualité garantie.</p>
                </div>

                <div
                    class="p-6 rounded-2xl bg-gradient-to-br from-emerald-500/10 to-transparent border border-emerald-500/20 hover:border-emerald-500/40 transition-all duration-300 group">
                    <div class="icon-ring w-12 h-12 rounded-xl bg-emerald-500/20 mb-5">
                        <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                    </div>
                    <h3 class="font-display text-white font-700 text-lg mb-2">Mises à jour gratuites</h3>
                    <p class="text-slate-400 text-sm leading-relaxed">Recevez toutes les mises à jour futures de vos
                        produits sans coût additionnel.</p>
                </div>

                <div
                    class="p-6 rounded-2xl bg-gradient-to-br from-rose-500/10 to-transparent border border-rose-500/20 hover:border-rose-500/40 transition-all duration-300 group">
                    <div class="icon-ring w-12 h-12 rounded-xl bg-rose-500/20 mb-5">
                        <svg class="w-5 h-5 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <h3 class="font-display text-white font-700 text-lg mb-2">Support dédié</h3>
                    <p class="text-slate-400 text-sm leading-relaxed">Une équipe à votre disposition 7j/7 pour vous
                        accompagner à chaque étape.</p>
                </div>

                <div
                    class="p-6 rounded-2xl bg-gradient-to-br from-sky-500/10 to-transparent border border-sky-500/20 hover:border-sky-500/40 transition-all duration-300 group">
                    <div class="icon-ring w-12 h-12 rounded-xl bg-sky-500/20 mb-5">
                        <svg class="w-5 h-5 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="font-display text-white font-700 text-lg mb-2">Remboursement 14 jours</h3>
                    <p class="text-slate-400 text-sm leading-relaxed">Pas satisfait ? Obtenez un remboursement complet
                        sous 14 jours, sans question.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== TESTIMONIALS ===== -->
    <section class="max-w-7xl mx-auto px-6 py-20">
        <div class="text-center mb-14">
            <div class="text-violet-400 text-sm font-medium mb-3">Témoignages</div>
            <h2 class="font-display text-3xl md:text-4xl font-700 text-white">Ce que disent nos <span
                    class="grad-text">clients</span></h2>
        </div>

        <div class="grid md:grid-cols-3 gap-5">
            <div class="testi-card rounded-2xl p-6">
                <div class="stars text-sm mb-3">★★★★★</div>
                <p class="text-slate-300 text-sm leading-relaxed mb-5">"Des produits d'une qualité exceptionnelle. Le
                    Dashboard UI Kit m'a fait gagner des semaines de travail. Je recommande vivement PixelVault !"</p>
                <div class="flex items-center gap-3">
                    <div
                        class="w-9 h-9 rounded-full bg-gradient-to-br from-violet-500 to-cyan-400 flex items-center justify-center text-white text-sm font-700">
                        S</div>
                    <div>
                        <div class="text-white text-sm font-600">Sophie M.</div>
                        <div class="text-slate-500 text-xs">UI Designer, Freelance</div>
                    </div>
                </div>
            </div>

            <div class="testi-card rounded-2xl p-6">
                <div class="stars text-sm mb-3">★★★★★</div>
                <p class="text-slate-300 text-sm leading-relaxed mb-5">"La plateforme est intuitive et les produits
                    sont vraiment premium. J'ai économisé énormément de temps sur mes projets clients."</p>
                <div class="flex items-center gap-3">
                    <div
                        class="w-9 h-9 rounded-full bg-gradient-to-br from-amber-500 to-rose-400 flex items-center justify-center text-white text-sm font-700">
                        K</div>
                    <div>
                        <div class="text-white text-sm font-600">Karim B.</div>
                        <div class="text-slate-500 text-xs">Développeur Full Stack</div>
                    </div>
                </div>
            </div>

            <div class="testi-card rounded-2xl p-6">
                <div class="stars text-sm mb-3">★★★★★</div>
                <p class="text-slate-300 text-sm leading-relaxed mb-5">"Le support est réactif et les mises à jour sont
                    régulières. C'est la référence pour les produits digitaux de qualité."</p>
                <div class="flex items-center gap-3">
                    <div
                        class="w-9 h-9 rounded-full bg-gradient-to-br from-emerald-500 to-cyan-400 flex items-center justify-center text-white text-sm font-700">
                        A</div>
                    <div>
                        <div class="text-white text-sm font-600">Amina L.</div>
                        <div class="text-slate-500 text-xs">Product Manager</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== CTA ===== -->
    <section class="max-w-7xl mx-auto px-6 py-20">
        <div class="relative rounded-3xl overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-violet-900/80 to-cyan-900/40"></div>
            <div class="absolute inset-0 grid-bg opacity-30"></div>
            <div class="absolute top-0 left-0 w-64 h-64 bg-violet-500/20 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 right-0 w-64 h-64 bg-cyan-500/20 rounded-full blur-3xl"></div>

            <div class="relative z-10 text-center py-20 px-6">
                <div
                    class="inline-block bg-white/5 border border-white/10 rounded-full px-4 py-1.5 text-xs text-slate-300 mb-6">
                    🎁 Inscription gratuite — Aucune carte requise
                </div>
                <h2 class="font-display text-4xl md:text-6xl font-800 text-white mb-6 leading-tight">
                    Commencez à créer<br />
                    <span class="grad-text">dès aujourd'hui.</span>
                </h2>
                <p class="text-slate-300 text-lg max-w-xl mx-auto mb-10">
                    Rejoignez plus de 12 000 créatifs qui font confiance à PixelVault pour leurs projets digitaux.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <button
                        class="btn-primary text-white px-10 py-4 rounded-xl font-medium text-base flex items-center gap-2 justify-center">
                        Créer mon compte gratuitement
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </button>
                    <button class="btn-outline text-white px-10 py-4 rounded-xl font-medium text-base border-white/20">
                        Voir tous les produits
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== FOOTER ===== -->
    <footer class="border-t border-white/5 py-12">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid md:grid-cols-4 gap-8 mb-10">
                <div>
                    <div class="flex items-center gap-2 mb-4">
                        <div
                            class="w-7 h-7 rounded-lg bg-gradient-to-br from-violet-600 to-cyan-500 flex items-center justify-center">
                            <svg class="w-3.5 h-3.5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z" />
                            </svg>
                        </div>
                        <span class="font-display font-700 text-white">Pixel<span
                                class="grad-text">Vault</span></span>
                    </div>
                    <p class="text-slate-500 text-sm leading-relaxed">La marketplace premium pour tous vos produits
                        digitaux.</p>
                </div>
                <div>
                    <div class="text-white text-sm font-600 mb-4">Produits</div>
                    <ul class="space-y-2 text-slate-500 text-sm">
                        <li><a href="#" class="hover:text-slate-300 transition-colors">UI Kits</a></li>
                        <li><a href="#" class="hover:text-slate-300 transition-colors">Templates</a></li>
                        <li><a href="#" class="hover:text-slate-300 transition-colors">Cours en ligne</a></li>
                        <li><a href="#" class="hover:text-slate-300 transition-colors">Plugins</a></li>
                    </ul>
                </div>
                <div>
                    <div class="text-white text-sm font-600 mb-4">Entreprise</div>
                    <ul class="space-y-2 text-slate-500 text-sm">
                        <li><a href="#" class="hover:text-slate-300 transition-colors">À propos</a></li>
                        <li><a href="#" class="hover:text-slate-300 transition-colors">Blog</a></li>
                        <li><a href="#" class="hover:text-slate-300 transition-colors">Carrières</a></li>
                        <li><a href="#" class="hover:text-slate-300 transition-colors">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <div class="text-white text-sm font-600 mb-4">Newsletter</div>
                    <p class="text-slate-500 text-sm mb-4">Recevez les meilleures offres chaque semaine.</p>
                    <div class="flex">
                        <input type="email" placeholder="votre@email.com"
                            class="flex-1 bg-white/5 border border-white/10 rounded-l-lg px-3 py-2 text-sm text-slate-300 placeholder-slate-600 focus:outline-none focus:border-violet-500/50" />
                        <button class="btn-primary text-white px-4 py-2 rounded-r-lg text-sm font-medium">OK</button>
                    </div>
                </div>
            </div>

            <div
                class="pt-8 border-t border-white/5 flex flex-col md:flex-row items-center justify-between gap-4 text-slate-600 text-xs">
                <span>© 2024 PixelVault. Tous droits réservés.</span>
                <div class="flex gap-6">
                    <a href="#" class="hover:text-slate-400 transition-colors">Confidentialité</a>
                    <a href="#" class="hover:text-slate-400 transition-colors">CGU</a>
                    <a href="#" class="hover:text-slate-400 transition-colors">Cookies</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Custom cursor
        const cursor = document.getElementById('cursor');
        const ring = document.getElementById('cursorRing');
        let mouseX = 0,
            mouseY = 0,
            ringX = 0,
            ringY = 0;

        document.addEventListener('mousemove', e => {
            mouseX = e.clientX;
            mouseY = e.clientY;
            cursor.style.left = mouseX + 'px';
            cursor.style.top = mouseY + 'px';
        });

        function animateRing() {
            ringX += (mouseX - ringX) * 0.12;
            ringY += (mouseY - ringY) * 0.12;
            ring.style.left = ringX + 'px';
            ring.style.top = ringY + 'px';
            requestAnimationFrame(animateRing);
        }
        animateRing();

        // Cursor hover states
        document.querySelectorAll('a, button, .product-card, .cat-pill').forEach(el => {
            el.addEventListener('mouseenter', () => {
                cursor.style.width = '20px';
                cursor.style.height = '20px';
                ring.style.width = '50px';
                ring.style.height = '50px';
            });
            el.addEventListener('mouseleave', () => {
                cursor.style.width = '12px';
                cursor.style.height = '12px';
                ring.style.width = '36px';
                ring.style.height = '36px';
            });
        });

        // Category filter
        document.querySelectorAll('.cat-pill').forEach(pill => {
            pill.addEventListener('click', () => {
                document.querySelectorAll('.cat-pill').forEach(p => p.classList.remove('active'));
                pill.classList.add('active');
            });
        });

        // Intersection Observer for scroll animations
        const observer = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.animation = 'fadeUp 0.6s ease forwards';
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.1
        });

        document.querySelectorAll('.product-card, .testi-card').forEach(el => {
            el.style.opacity = '0';
            observer.observe(el);
        });
    </script>
</body>

</html>
