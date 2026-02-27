<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'PixelVault')</title>
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
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            overflow-x: hidden;
        }

        .sidebar.collapsed {
            width: 88px;
            padding: 24px 16px;
        }

        .sidebar.collapsed .sidebar-text,
        .sidebar.collapsed .sidebar-logo-text,
        .sidebar.collapsed .sidebar-hide {
            display: none;
        }

        .sidebar.collapsed .nav-link {
            justify-content: center;
            padding: 12px;
        }

        .sidebar.collapsed .logo-container {
            justify-content: center;
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
            white-space: nowrap;
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

        /* Main Content */
        .main-content {
            margin-left: 260px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            padding: 32px;
            min-height: 100vh;
        }

        .sidebar.collapsed + .main-content {
            margin-left: 88px;
        }

        /* Toggle Button */
        .toggle-btn {
            position: absolute;
            right: -12px;
            top: 32px;
            width: 24px;
            height: 24px;
            background: #7c3aed;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            cursor: pointer;
            z-index: 60;
            border: none;
            box-shadow: 0 4px 12px rgba(124, 58, 237, 0.4);
            transition: all 0.3s;
        }
        .sidebar.collapsed .toggle-btn {
            transform: rotate(180deg);
        }

        /* Orbs */
        .orb { position: fixed; border-radius: 50%; filter: blur(100px); pointer-events: none; z-index: -1; }

        /* Custom scrollbar */
        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-thumb { background: rgba(124, 58, 237, 0.2); border-radius: 10px; }

        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        .animate-fade { animation: fadeIn 0.5s ease-out forwards; }
    </style>
    @yield('styles')
</head>
<body>
    <!-- Background Orbs -->
    <div class="orb" style="width: 500px; height: 500px; background: rgba(124, 58, 237, 0.05); top: -100px; left: -100px;"></div>
    <div class="orb" style="width: 400px; height: 400px; background: rgba(6, 182, 212, 0.04); bottom: -50px; right: -50px;"></div>

    <!-- Sidebar -->
    <aside class="sidebar glass" id="sidebar">
        <button class="toggle-btn" id="toggleSidebar">
            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </button>

        <div class="flex items-center gap-3 mb-10 px-2 logo-container">
            <div class="w-8 h-8 rounded-lg bg-linear-to-br from-[#7c3aed] to-[#06b6d4] flex items-center justify-center shrink-0">
                <svg width="18" height="18" fill="#fff" viewBox="0 0 20 20"><path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z"/></svg>
            </div>
            <span class="text-xl font-bold font-syne text-white tracking-tight sidebar-logo-text">Pixel<span class="g">Vault</span></span>
        </div>

        <nav class="flex-1">
            @auth
                @if(Auth::user()->role === 'createur')
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        <span class="sidebar-text">Dashboard</span>
                    </a>
                    <a href="{{ route('allProduct') }}" class="nav-link {{ request()->routeIs('allProduct') ? 'active' : '' }}">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        <span class="sidebar-text">Mes Produits</span>
                    </a>
                    <a href="{{ route('analytics') }}" class="nav-link {{ request()->routeIs('analytics') ? 'active' : '' }}">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0h6m2 0h2a2 2 0 002-2v-4a2 2 0 00-2-2h-2a2 2 0 00-2 2v4a2 2 0 002 2z"/></svg>
                        <span class="sidebar-text">Analytics</span>
                    </a>
                    <a href="{{ route('sales') }}" class="nav-link {{ request()->routeIs('sales') ? 'active' : '' }}">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span class="sidebar-text">Ventes</span>
                    </a>
                @elseif(Auth::user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0h6m2 0h2a2 2 0 002-2v-4a2 2 0 00-2-2h-2a2 2 0 00-2 2v4a2 2 0 002 2z"/></svg>
                        <span class="sidebar-text">Admin Dashboard</span>
                    </a>
                    <a href="{{ route('admin.users') }}" class="nav-link {{ request()->routeIs('admin.users') ? 'active' : '' }}">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        <span class="sidebar-text">Utilisateurs</span>
                    </a>
                    <a href="{{ route('admin.products') }}" class="nav-link {{ request()->routeIs('admin.products') ? 'active' : '' }}">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        <span class="sidebar-text">Produits</span>
                    </a>
                @else
                    <a href="{{ route('explorer') }}" class="nav-link {{ request()->routeIs('explorer') ? 'active' : '' }}">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <span class="sidebar-text">Explorer</span>
                    </a>
                    <a href="{{ route('client.purchases') }}" class="nav-link {{ request()->routeIs('client.purchases') ? 'active' : '' }}">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        <span class="sidebar-text">Mes Achats</span>
                    </a>
                @endif
                <a href="{{ route('settings') }}" class="nav-link {{ request()->routeIs('settings') ? 'active' : '' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37a1.724 1.724 0 002.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <span class="sidebar-text">Settings</span>
                </a>
            @else
                <a href="{{ route('explorer') }}" class="nav-link {{ request()->routeIs('explorer') ? 'active' : '' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <span class="sidebar-text">Explorer</span>
                </a>
                <a href="{{ route('login') }}" class="nav-link {{ request()->routeIs('login') ? 'active' : '' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    <span class="sidebar-text">Connexion</span>
                </a>
            @endauth
        </nav>

        <div class="mt-auto">
            @auth
                <div class="glass p-4 rounded-xl mb-6 sidebar-hide">
                    <p class="text-xs text-slate-500 mb-2 uppercase tracking-widest font-bold">Plan Actuel</p>
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-bold text-white">{{ ucfirst(Auth::user()->plan ?? 'Gratuit') }}</span>
                        <a href="#" class="text-[10px] text-purple-400 hover:text-purple-300 font-bold underline">Upgrade</a>
                    </div>
                </div>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-red-400 hover:bg-red-400/10 transition-colors text-sm font-medium">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        <span class="sidebar-text">Déconnexion</span>
                    </button>
                </form>
            @else
                <div class="glass p-4 rounded-xl mb-6 sidebar-hide">
                    <p class="text-xs text-slate-500 mb-2 uppercase tracking-widest font-bold">Nouveau ici ?</p>
                    <p class="text-[10px] text-slate-400 mb-4">Créez un compte pour acheter ou vendre des produits.</p>
                    <a href="{{ route('register') }}" class="w-full btn-primary text-white text-[10px] py-2 rounded-lg font-bold flex items-center justify-center">
                        S'inscrire
                    </a>
                </div>
            @endauth
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        @yield('content')
    </main>

    <script>
        // Sidebar Toggle Logic
        const sidebar = document.getElementById('sidebar');
        const toggleBtn = document.getElementById('toggleSidebar');
        
        // Load state from localStorage
        if (localStorage.getItem('sidebar-collapsed') === 'true') {
            sidebar.classList.add('collapsed');
        }

        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
            localStorage.setItem('sidebar-collapsed', sidebar.classList.contains('collapsed'));
        });

        // Micro interactions for glass cards
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
    @yield('scripts')
</body>
</html>
