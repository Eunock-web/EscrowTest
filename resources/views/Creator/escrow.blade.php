@extends('layouts.app')

@section('title', 'PixelVault — Paiements Escrow')

@section('content')
    <div class="animate-fade">
        {{-- Header --}}
        <div class="flex items-center justify-between mb-10">
            <div>
                <h1 class="text-4xl font-extrabold text-white mb-2">Paiements <span class="g">Escrow</span></h1>
                <p class="text-slate-500">Gérez les fonds en attente avant de les libérer.</p>
            </div>
            <div class="flex items-center gap-3">
                {{-- Stats badge --}}
                <div class="glass px-5 py-3 rounded-2xl border border-white/10 flex items-center gap-3">
                    <div class="w-2.5 h-2.5 rounded-full bg-amber-400 animate-pulse"></div>
                    <div>
                        <p class="text-[10px] text-slate-500 uppercase tracking-widest">En Attente</p>
                        <p class="text-lg font-extrabold text-white leading-none">{{ $pendingSales->total() }}</p>
                    </div>
                </div>
                <div class="glass px-5 py-3 rounded-2xl border border-white/10 flex items-center gap-3">
                    <div class="w-2.5 h-2.5 rounded-full bg-amber-400/50"></div>
                    <div>
                        <p class="text-[10px] text-slate-500 uppercase tracking-widest">Montant Bloqué</p>
                        <p class="text-lg font-extrabold text-amber-400 leading-none">{{ number_format($totalPending, 0) }} XOF</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Alert Banner --}}
        <div class="mb-8 p-5 rounded-2xl border border-amber-500/20 bg-amber-500/5 flex items-start gap-4 animate-fade" style="animation-delay: 0.1s;">
            <div class="w-10 h-10 rounded-xl bg-amber-500/10 flex items-center justify-center flex-shrink-0 mt-0.5">
                🔒
            </div>
            <div>
                <p class="text-sm font-bold text-amber-300 mb-1">Comment fonctionne l'Escrow ?</p>
                <p class="text-xs text-slate-400 leading-relaxed">
                    Le montant de chaque vente est sécurisé et en attente jusqu'à ce que vous confirmiez la livraison du produit.
                    Une fois validé, le paiement est libéré et versé à votre compte.
                </p>
            </div>
        </div>

        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="mb-6 p-4 rounded-2xl border border-emerald-500/20 bg-emerald-500/5 flex items-center gap-3 animate-fade">
                <span class="text-xl">✅</span>
                <p class="text-sm font-medium text-emerald-400">{{ session('success') }}</p>
            </div>
        @endif
        @if(session('error'))
            <div class="mb-6 p-4 rounded-2xl border border-red-500/20 bg-red-500/5 flex items-center gap-3 animate-fade">
                <span class="text-xl">❌</span>
                <p class="text-sm font-medium text-red-400">{{ session('error') }}</p>
            </div>
        @endif

        {{-- Pending Sales Table --}}
        <div class="glass rounded-3xl border border-white/5 overflow-hidden animate-fade" style="animation-delay: 0.2s;">
            <div class="px-8 py-6 border-b border-white/5 flex items-center justify-between">
                <h4 class="text-lg font-bold text-white flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-amber-400 animate-pulse inline-block"></span>
                    Transactions en attente
                </h4>
                <span class="text-xs text-slate-500 font-medium">{{ $pendingSales->total() }} transaction(s)</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-white/5 bg-white/2">
                            <th class="px-8 py-5 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Produit</th>
                            <th class="px-8 py-5 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Acheteur</th>
                            <th class="px-8 py-5 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Date de paiement</th>
                            <th class="px-8 py-5 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Montant</th>
                            <th class="px-8 py-5 text-[10px] font-bold text-slate-500 uppercase tracking-widest text-center">Statut</th>
                            <th class="px-8 py-5 text-[10px] font-bold text-slate-500 uppercase tracking-widest text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @forelse($pendingSales as $sale)
                            <tr class="hover:bg-white/2 transition-colors group">
                                {{-- Product --}}
                                <td class="px-8 py-5">
                                    <div class="flex items-center gap-4">
                                        <div class="w-11 h-11 rounded-xl bg-gradient-to-tr from-amber-500/10 to-orange-500/10 border border-amber-500/10 flex items-center justify-center text-lg flex-shrink-0">
                                            📦
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-white">{{ $sale->product->nom }}</p>
                                            <p class="text-[10px] text-slate-500">Vente #{{ $sale->id }}</p>
                                        </div>
                                    </div>
                                </td>
                                {{-- Buyer --}}
                                <td class="px-8 py-5">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-7 h-7 rounded-lg bg-gradient-to-tr from-purple-500 to-blue-500 flex items-center justify-center text-[9px] font-bold text-white flex-shrink-0">
                                            {{ substr($sale->buyer->firstname, 0, 1) }}{{ substr($sale->buyer->lastname, 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="text-sm text-white font-medium">{{ $sale->buyer->pseudo }}</p>
                                            <p class="text-[10px] text-slate-500">{{ $sale->buyer->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                {{-- Date --}}
                                <td class="px-8 py-5">
                                    <p class="text-xs text-slate-300">{{ $sale->created_at->format('d M Y') }}</p>
                                    <p class="text-[10px] text-slate-500">{{ $sale->created_at->diffForHumans() }}</p>
                                </td>
                                {{-- Amount --}}
                                <td class="px-8 py-5">
                                    <p class="text-sm font-extrabold text-amber-400">{{ number_format($sale->amount, 0) }} XOF</p>
                                </td>
                                {{-- Status --}}
                                <td class="px-8 py-5">
                                    <div class="flex justify-center">
                                        <span class="px-3 py-1 rounded-lg bg-amber-500/10 text-amber-400 text-[10px] font-bold uppercase border border-amber-500/20 flex items-center gap-1.5">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-400 animate-pulse"></span>
                                            En attente
                                        </span>
                                    </div>
                                </td>
                                {{-- Action --}}
                                <td class="px-8 py-5">
                                    <div class="flex justify-center">
                                        <form action="{{ route('creator.escrow.confirm', $sale->id) }}" method="POST"
                                              onsubmit="return confirm('Confirmer la livraison de ce produit ? Le paiement sera libéré.');">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                class="px-4 py-2 rounded-xl text-xs font-bold text-white
                                                       bg-gradient-to-r from-emerald-500 to-teal-500
                                                       hover:from-emerald-400 hover:to-teal-400
                                                       shadow-lg shadow-emerald-500/20
                                                       transition-all duration-200 hover:scale-105 active:scale-95
                                                       flex items-center gap-1.5">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                                </svg>
                                                Valider livraison
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-8 py-20 text-center">
                                    <div class="text-5xl mb-4 opacity-20">🔒</div>
                                    <p class="text-slate-400 font-bold mb-1">Aucun paiement en attente</p>
                                    <p class="text-[11px] text-slate-600 uppercase tracking-widest">Les ventes escrow apparaîtront ici</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($pendingSales->hasPages())
                <div class="px-8 py-4 border-t border-white/5 bg-white/2">
                    {{ $pendingSales->links() }}
                </div>
            @endif
        </div>

        {{-- Completed section --}}
        @if($completedSales->count())
        <div class="mt-10 glass rounded-3xl border border-white/5 overflow-hidden animate-fade" style="animation-delay: 0.3s;">
            <div class="px-8 py-6 border-b border-white/5">
                <h4 class="text-lg font-bold text-white flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 inline-block"></span>
                    Paiements libérés récemment
                </h4>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-white/5 bg-white/2">
                            <th class="px-8 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Produit</th>
                            <th class="px-8 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Acheteur</th>
                            <th class="px-8 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Libéré le</th>
                            <th class="px-8 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Montant</th>
                            <th class="px-8 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest text-center">Statut</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @foreach($completedSales as $sale)
                            <tr class="hover:bg-white/2 transition-colors opacity-70 hover:opacity-100">
                                <td class="px-8 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-xl bg-slate-800 flex items-center justify-center text-base flex-shrink-0">📦</div>
                                        <p class="text-sm font-bold text-white">{{ $sale->product->nom }}</p>
                                    </div>
                                </td>
                                <td class="px-8 py-4">
                                    <span class="text-sm text-slate-300">{{ $sale->buyer->pseudo }}</span>
                                </td>
                                <td class="px-8 py-4">
                                    <span class="text-xs text-slate-400">{{ $sale->updated_at->format('d M Y') }}</span>
                                </td>
                                <td class="px-8 py-4">
                                    <span class="text-sm font-extrabold text-emerald-400">+{{ number_format($sale->amount, 0) }} XOF</span>
                                </td>
                                <td class="px-8 py-4 text-center">
                                    <span class="px-2.5 py-1 rounded-lg bg-emerald-500/10 text-emerald-400 text-[10px] font-bold uppercase border border-emerald-500/20">
                                        Libéré
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

    </div>
@endsection
