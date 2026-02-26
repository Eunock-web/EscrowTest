<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PixelVault — Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            background: #050509;
            color: #e2e8f0;
            font-family: 'DM Sans', sans-serif;
            overflow-x: hidden;
            min-height: 100vh;
        }
        h1, h2, h3, h4 { font-family: 'Syne', sans-serif; }
        
        .g { background: linear-gradient(135deg, #a78bfa, #22d3ee); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .glass { background: rgba(255, 255, 255, 0.03); backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.06); }
        .glass-hover:hover { background: rgba(255, 255, 255, 0.05); border-color: rgba(124, 58, 237, 0.3); }
        
        /* Sidebar */
        .sidebar {
            width: 260px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            border-right: 1px solid rgba(255, 255, 255, 0.05);
            z-index: 50;
            padding: 24px;
            display: flex;
            flex-direction: column;
        }
        
        .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            border-radius: 12px;
            color: #94a3b8;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            margin-bottom: 4px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
        }
        .nav-link:hover, .nav-link.active {
            color: #fff;
            background: rgba(124, 58, 237, 0.1);
        }
        .nav-link.active {
            color: #a78bfa;
            border-left: 3px solid #7c3aed;
            border-radius: 4px 12px 12px 4px;
        }

        /* Orbs */
        .orb { position: fixed; border-radius: 50%; filter: blur(100px); pointer-events: none; z-index: -1; }

        /* Custom scrollbar */
        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-thumb { background: rgba(124, 58, 237, 0.2); border-radius: 10px; }

        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        .animate-fade { animation: fadeIn 0.5s ease out forwards; }
    </style>
</head>
<body>
    <!-- Background Orbs -->
    <div class="orb" style="width: 500px; height: 500px; background: rgba(124, 58, 237, 0.05); top: -100px; left: -100px;"></div>
    <div class="orb" style="width: 400px; height: 400px; background: rgba(6, 182, 212, 0.04); bottom: -50px; right: -50px;"></div>

    <!-- Sidebar -->
    <aside class="sidebar glass">
        <div class="flex items-center gap-3 mb-10 px-2">
            <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-[#7c3aed] to-[#06b6d4] flex items-center justify-center">
                <svg width="18" height="18" fill="#fff" viewBox="0 0 20 20"><path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z"/></svg>
            </div>
            <span class="text-xl font-bold font-syne text-white tracking-tight">Pixel<span class="g">Vault</span></span>
        </div>

        <nav class="flex-1">
            <a href="#" class="nav-link active">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Dashboard
            </a>
            <a href="#" class="nav-link">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                Mes Produits
            </a>
            <a href="#" class="nav-link">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0h6m2 0h2a2 2 0 002-2v-4a2 2 0 00-2-2h-2a2 2 0 00-2 2v4a2 2 0 002 2z"/></svg>
                Analytics
            </a>
            <a href="#" class="nav-link">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Ventes
            </a>
            <a href="#" class="nav-link">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37a1.724 1.724 0 002.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                Settings
            </a>
        </nav>

        <div class="mt-auto">
            <div class="glass p-4 rounded-xl mb-6">
                <p class="text-xs text-slate-500 mb-2 uppercase tracking-widest font-bold">Plan Actuel</p>
                <div class="flex items-center justify-between">
                    <span class="text-sm font-bold text-white">{{ ucfirst(Auth::user()->plan ?? 'Gratuit') }}</span>
                    <a href="#" class="text-[10px] text-purple-400 hover:text-purple-300 font-bold underline">Upgrade</a>
                </div>
            </div>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-red-400 hover:bg-red-400/10 transition-colors text-sm font-medium">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    Déconnexion
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="ml-[260px] p-8">
        <!-- Header -->
        <header class="flex items-center justify-between mb-10 animate-fade" style="animation-delay: 0.1s;">
            <div>
                <h2 class="text-3xl font-extrabold text-white">Salut, {{ Auth::user()->firstname }} <span class="animate-pulse text-2xl">👋</span></h2>
                <p class="text-slate-500 mt-1">Voici l'état de votre compte créateur PixelVault.</p>
            </div>
            
            <div class="flex items-center gap-4">
                <button class="glass p-2.5 rounded-xl glass-hover relative">
                    <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                    <span class="absolute top-2 right-2 w-2 h-2 bg-purple-500 rounded-full border-2 border-[#050509]"></span>
                </button>
                <div class="flex items-center gap-3 glass p-1.5 pr-4 rounded-xl border border-white/10">
                    <div class="w-10 h-10 rounded-lg bg-gradient-to-tr from-purple-500 to-blue-500 flex items-center justify-center font-bold text-white shadow-lg shadow-purple-500/20 uppercase">
                        {{ substr(Auth::user()->firstname, 0, 1) }}{{ substr(Auth::user()->lastname, 0, 1) }}
                    </div>
                    <div class="hidden md:block">
                        <p class="text-xs font-bold text-white leading-none mb-1">{{ Auth::user()->pseudo }}</p>
                        <p class="text-[10px] text-slate-500 uppercase tracking-tighter">{{ Auth::user()->specialite ?? 'Créateur' }}</p>
                    </div>
                </div>
            </div>
        </header>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10 animate-fade" style="animation-delay: 0.2s;">
            <div class="glass p-6 rounded-2xl relative overflow-hidden group">
                <div class="absolute -right-4 -top-4 w-24 h-24 bg-purple-600/10 rounded-full blur-2xl group-hover:bg-purple-600/20 transition-all"></div>
                <p class="text-sm text-slate-500 font-medium mb-1">Revenus Totaux</p>
                <h3 class="text-3xl font-extrabold text-white mb-2">1,280<span class="g">€</span></h3>
                <div class="flex items-center gap-1.5 text-xs font-bold text-emerald-400">
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd"/></svg>
                    +12%
                </div>
            </div>
            
            <div class="glass p-6 rounded-2xl relative overflow-hidden group">
                <div class="absolute -right-4 -top-4 w-24 h-24 bg-blue-600/10 rounded-full blur-2xl group-hover:bg-blue-600/20 transition-all"></div>
                <p class="text-sm text-slate-500 font-medium mb-1">Ventes du mois</p>
                <h3 class="text-3xl font-extrabold text-white mb-2">42</h3>
                <div class="flex items-center gap-1.5 text-xs font-bold text-emerald-400">
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd"/></svg>
                    +8%
                </div>
            </div>

            <div class="glass p-6 rounded-2xl relative overflow-hidden group">
                <div class="absolute -right-4 -top-4 w-24 h-24 bg-cyan-600/10 rounded-full blur-2xl group-hover:bg-cyan-600/20 transition-all"></div>
                <p class="text-sm text-slate-500 font-medium mb-1">Vues Produits</p>
                <h3 class="text-3xl font-extrabold text-white mb-2">3.4k</h3>
                <div class="flex items-center gap-1.5 text-xs font-bold text-slate-400">
                    Stable ce mois
                </div>
            </div>

            <div class="glass p-6 rounded-2xl relative overflow-hidden group">
                <div class="absolute -right-4 -top-4 w-24 h-24 bg-orange-600/10 rounded-full blur-2xl group-hover:bg-orange-600/20 transition-all"></div>
                <p class="text-sm text-slate-500 font-medium mb-1">Score Créateur</p>
                <h3 class="text-3xl font-extrabold text-white mb-2">98<span class="text-purple-500 text-lg">/100</span></h3>
                <div class="flex items-center gap-1.5 text-xs font-bold text-emerald-400">
                    Excellence
                </div>
            </div>
        </div>

        <!-- content two columns -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-10">
            <!-- Recent Sales -->
            <div class="lg:col-span-2 glass rounded-3xl p-8 animate-fade" style="animation-delay: 0.3s;">
                <div class="flex items-center justify-between mb-8">
                    <h4 class="text-xl font-bold text-white">Ventes Récentes</h4>
                    <a href="#" class="text-sm text-purple-400 hover:text-purple-300 transition-colors">Voir tout →</a>
                </div>

                <div class="space-y-6">
                    <div class="flex items-center justify-between p-4 rounded-2xl glass-hover border border-transparent transition-all">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-slate-800 flex items-center justify-center text-xl">📦</div>
                            <div>
                                <p class="text-sm font-bold text-white">3D iPhone 15 Pro Mockup</p>
                                <p class="text-xs text-slate-500">Acheté par @design_flow</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-bold text-emerald-400">+19.00€</p>
                            <p class="text-[10px] text-slate-600 uppercase">Aujourd'hui, 14:24</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between p-4 rounded-2xl glass-hover border border-transparent transition-all">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-slate-800 flex items-center justify-center text-xl">🖼️</div>
                            <div>
                                <p class="text-sm font-bold text-white">Abstract Gradient Pack</p>
                                <p class="text-xs text-slate-500">Acheté par @artisan_web</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-bold text-emerald-400">+15.00€</p>
                            <p class="text-[10px] text-slate-600 uppercase">Hier, 18:05</p>
                        </div>
                    </div>

                    <div class="flex items-center justify-between p-4 rounded-2xl glass-hover border border-transparent transition-all">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-slate-800 flex items-center justify-center text-xl">🎬</div>
                            <div>
                                <p class="text-sm font-bold text-white">Lottie Animation Pack</p>
                                <p class="text-xs text-slate-500">Acheté par @startup_x</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-bold text-emerald-400">+35.00€</p>
                            <p class="text-[10px] text-slate-600 uppercase">Hier, 10:42</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Profile Sidebar / Quick Stats -->
            <div class="glass rounded-3xl p-8 animate-fade" style="animation-delay: 0.4s;">
                <h4 class="text-xl font-bold text-white mb-6">Profil Créateur</h4>
                
                <div class="text-center mb-8">
                    <div class="w-24 h-24 rounded-2xl bg-gradient-to-tr from-purple-500 to-blue-500 mx-auto flex items-center justify-center text-3xl font-bold shadow-2xl shadow-purple-500/30 mb-4 ring-4 ring-white/5">
                        {{ substr(Auth::user()->firstname, 0, 1) }}{{ substr(Auth::user()->lastname, 0, 1) }}
                    </div>
                    <h5 class="text-lg font-bold text-white">{{ Auth::user()->firstname }} {{ Auth::user()->lastname }}</h5>
                    <p class="text-sm text-purple-400 font-medium">@ {{ Auth::user()->pseudo }}</p>
                </div>

                <div class="space-y-4">
                    <div class="p-4 rounded-2xl bg-white/5 border border-white/5">
                        <p class="text-xs text-slate-500 uppercase tracking-widest font-bold mb-2">Ma Bio</p>
                        <p class="text-sm text-slate-300 leading-relaxed italic">
                            "{{ Auth::user()->description ?? 'Pas de bio encore...' }}"
                        </p>
                    </div>

                    <div class="p-4 rounded-2xl bg-white/5 border border-white/5">
                        <p class="text-xs text-slate-500 uppercase tracking-widest font-bold mb-3">Spécialité</p>
                        <div class="flex flex-wrap gap-2">
                            <span class="px-3 py-1 bg-purple-500/20 text-purple-300 border border-purple-500/30 rounded-lg text-xs font-bold uppercase transition-transform hover:scale-105">
                                {{ Auth::user()->specialite ?? 'Généraliste' }}
                            </span>
                        </div>
                    </div>
                </div>

                <button class="w-full mt-8 bg-white/5 border border-white/10 hover:bg-white/10 transition-all rounded-xl py-3 text-sm font-bold text-white">
                    Éditer mon Profil
                </button>
            </div>
        </div>
    </main>

    <script>
        // Micro interactions
        document.querySelectorAll('.glass-hover').forEach(card => {
            card.addEventListener('mousemove', (e) => {
                const rect = card.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                card.style.setProperty('--x', `${x}px`);
                card.style.setProperty('--y', `${y}px`);
            });
        });
    </script>
</body>
</html>
