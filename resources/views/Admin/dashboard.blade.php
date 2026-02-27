@extends('layouts.app')

@section('title', 'Administration — Dashboard')

@section('content')
    <header class="flex items-center justify-between mb-10">
        <div>
            <h2 class="text-3xl font-extrabold text-white">Console d'Administration</h2>
            <p class="text-slate-500 mt-1">Vue d'ensemble de la plateforme PixelVault.</p>
        </div>
        
        <div class="flex items-center gap-3 glass p-1.5 pr-4 rounded-xl border border-white/10">
            <div class="w-10 h-10 rounded-lg bg-red-500 flex items-center justify-center font-bold text-white shadow-lg shadow-red-500/20 uppercase">
                ADM
            </div>
            <div>
                <p class="text-xs font-bold text-white leading-none mb-1">Administrateur</p>
                <p class="text-[10px] text-red-500 uppercase tracking-tighter">Accès Root</p>
            </div>
        </div>
    </header>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <div class="glass p-6 rounded-2xl border border-white/5">
            <p class="text-xs text-slate-500 font-bold uppercase tracking-widest mb-1">Revenus Plateforme</p>
            <h3 class="text-3xl font-extrabold text-white mb-2">{{ number_format($stats['totalRevenue'], 2) }}€</h3>
            <div class="text-xs font-bold text-emerald-400">Total cumulé</div>
        </div>

        <div class="glass p-6 rounded-2xl border border-white/5">
            <p class="text-xs text-slate-500 font-bold uppercase tracking-widest mb-1">Utilisateurs</p>
            <h3 class="text-3xl font-extrabold text-white mb-2">{{ $stats['totalUsers'] }}</h3>
            <div class="text-xs text-slate-400">
                <span class="text-purple-400">{{ $stats['creatorsCount'] }}</span> Créateurs / <span class="text-blue-400">{{ $stats['clientsCount'] }}</span> Clients
            </div>
        </div>

        <div class="glass p-6 rounded-2xl border border-white/5">
            <p class="text-xs text-slate-500 font-bold uppercase tracking-widest mb-1">Produits Actifs</p>
            <h3 class="text-3xl font-extrabold text-white mb-2">{{ $stats['totalProducts'] }}</h3>
            <div class="text-xs font-bold text-emerald-400">Mise en vente</div>
        </div>

        <div class="glass p-6 rounded-2xl border border-white/5">
            <p class="text-xs text-slate-500 font-bold uppercase tracking-widest mb-1">Transactions</p>
            <h3 class="text-3xl font-extrabold text-white mb-2">{{ $stats['totalSales'] }}</h3>
            <div class="text-xs font-bold text-slate-400">Ventes réussies</div>
        </div>
    </div>

    <!-- Analytics & Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-10">
        <div class="lg:col-span-2 glass rounded-3xl p-8">
            <h4 class="text-xl font-bold text-white mb-8">Flux des Revenus (7 derniers jours)</h4>
            <div class="h-64 flex items-end justify-between gap-2">
                @foreach($salesData as $data)
                    <div class="flex-1 group relative">
                        <div class="absolute -top-8 left-1/2 -translate-x-1/2 bg-white text-black text-[10px] font-bold px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity">
                            {{ $data->total }}€
                        </div>
                        <div class="bg-gradient-to-t from-purple-600 to-blue-400 rounded-t-lg transition-all hover:brightness-125" style="height: {{ ($data->total / max($salesData->pluck('total')->toArray() ?: [1])) * 200 }}px"></div>
                        <p class="text-[10px] text-slate-600 mt-2 text-center">{{ date('d/m', strtotime($data->date)) }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="glass rounded-3xl p-8">
            <h4 class="text-xl font-bold text-white mb-6">Répartition Rôles</h4>
            <div class="space-y-6">
                <div>
                    <div class="flex justify-between text-xs font-bold mb-2">
                        <span class="text-purple-400">CRÉATEURS</span>
                        <span class="text-white">{{ round(($stats['creatorsCount'] / max($stats['totalUsers'], 1)) * 100) }}%</span>
                    </div>
                    <div class="w-full bg-white/5 h-2 rounded-full overflow-hidden">
                        <div class="bg-purple-500 h-full" style="width: {{ ($stats['creatorsCount'] / max($stats['totalUsers'], 1)) * 100 }}%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between text-xs font-bold mb-2">
                        <span class="text-blue-400">CLIENTS</span>
                        <span class="text-white">{{ round(($stats['clientsCount'] / max($stats['totalUsers'], 1)) * 100) }}%</span>
                    </div>
                    <div class="w-full bg-white/5 h-2 rounded-full overflow-hidden">
                        <div class="bg-blue-500 h-full" style="width: {{ ($stats['clientsCount'] / max($stats['totalUsers'], 1)) * 100 }}%"></div>
                    </div>
                </div>
            </div>

            <div class="mt-10 p-4 rounded-2xl bg-white/5 border border-white/5">
                <p class="text-xs text-slate-500 font-bold uppercase mb-2">Alerte Système</p>
                <p class="text-xs text-slate-400 leading-relaxed">
                    La plateforme fonctionne normalement. Aucun litige en attente de modération.
                </p>
            </div>
        </div>
    </div>
@endsection
