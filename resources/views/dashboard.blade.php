@extends('layouts.app')

@section('title', 'PixelVault — Dashboard')

@section('content')
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
                <div class="w-10 h-10 rounded-lg bg-linear-to-tr from-purple-500 to-blue-500 flex items-center justify-center font-bold text-white shadow-lg shadow-purple-500/20 uppercase">
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
            <h3 class="text-3xl font-extrabold text-white mb-2">{{ number_format($totalRevenue, 2) }}<span class="g">€</span></h3>
            <div class="flex items-center gap-1.5 text-xs font-bold text-emerald-400">
                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd"/></svg>
                +12%
            </div>
        </div>

        <div class="glass p-6 rounded-2xl relative overflow-hidden group">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-blue-600/10 rounded-full blur-2xl group-hover:bg-blue-600/20 transition-all"></div>
            <p class="text-sm text-slate-500 font-medium mb-1">Ventes totales</p>
            <h3 class="text-3xl font-extrabold text-white mb-2">{{ $totalSales }}</h3>
            <div class="flex items-center gap-1.5 text-xs font-bold text-emerald-400">
                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd"/></svg>
                +8%
            </div>
        </div>

        <div class="glass p-6 rounded-2xl relative overflow-hidden group">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-cyan-600/10 rounded-full blur-2xl group-hover:bg-cyan-600/20 transition-all"></div>
            <p class="text-sm text-slate-500 font-medium mb-1">Vues Produits</p>
            <h3 class="text-3xl font-extrabold text-white mb-2">{{ $totalViews }}</h3>
            <div class="flex items-center gap-1.5 text-xs font-bold text-slate-400">
                Stable ce mois
            </div>
        </div>

        <div class="glass p-6 rounded-2xl relative overflow-hidden group">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-orange-600/10 rounded-full blur-2xl group-hover:bg-orange-600/20 transition-all"></div>
            <p class="text-sm text-slate-500 font-medium mb-1">Mes Produits</p>
            <h3 class="text-3xl font-extrabold text-white mb-2">{{ $totalProducts }}</h3>
            <div class="flex items-center gap-1.5 text-xs font-bold text-orange-400">
                En ligne
            </div>
        </div>
    </div>

    <!-- content two columns -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-10">
        <!-- Recent Sales -->
        <div class="lg:col-span-2 glass rounded-3xl p-8 animate-fade" style="animation-delay: 0.3s;">
            <div class="flex items-center justify-between mb-8">
                <h4 class="text-xl font-bold text-white">Ventes Récentes</h4>
                <a href="{{ route('sales') }}" class="text-sm text-purple-400 hover:text-purple-300 transition-colors">Voir tout →</a>
            </div>

            <div class="space-y-6">
                @forelse($recentSales as $sale)
                    <div class="flex items-center justify-between p-4 rounded-2xl glass-hover border border-transparent transition-all">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-slate-800 flex items-center justify-center text-xl">📦</div>
                            <div>
                                <p class="text-sm font-bold text-white">{{ $sale->product->nom }}</p>
                                <p class="text-xs text-slate-500">Acheté par @ {{ $sale->buyer->pseudo }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-bold text-emerald-400">+{{ number_format($sale->amount, 2) }}€</p>
                            <p class="text-[10px] text-slate-600 uppercase">{{ $sale->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-10">
                        <p class="text-slate-500 text-sm">Aucune vente récente.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Profile Sidebar / Quick Stats -->
        <div class="glass rounded-3xl p-8 animate-fade" style="animation-delay: 0.4s;">
            <h4 class="text-xl font-bold text-white mb-6">Profil Créateur</h4>

            <div class="text-center mb-8">
                <div class="w-24 h-24 rounded-2xl bg-linear-to-tr from-purple-500 to-blue-500 mx-auto flex items-center justify-center text-3xl font-bold shadow-2xl shadow-purple-500/30 mb-4 ring-4 ring-white/5">
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

            <a href="{{ route('settings') }}" class="block w-full mt-8 bg-white/5 border border-white/10 hover:bg-white/10 transition-all rounded-xl py-3 text-sm font-bold text-white text-center">
                Éditer mon Profil
            </a>
        </div>
    </div>
@endsection
