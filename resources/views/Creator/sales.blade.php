@extends('layouts.app')

@section('title', 'PixelVault — Mes Ventes')

@section('content')
    <div class="animate-fade">
        <div class="flex items-center justify-between mb-10">
            <div>
                <h1 class="text-4xl font-extrabold text-white mb-2">Mes <span class="g">ventes</span></h1>
                <p class="text-slate-500">Historique complet de vos transactions sur PixelVault.</p>
            </div>
            <div class="flex items-center gap-3">
                <button class="px-4 py-2 bg-white/5 border border-white/10 rounded-xl text-white text-xs font-bold hover:bg-white/10 transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    Exporter CSV
                </button>
            </div>
        </div>

        <div class="glass rounded-3xl border-white/5 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-white/5 bg-white/2">
                            <th class="px-8 py-5 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Produit</th>
                            <th class="px-8 py-5 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Acheteur</th>
                            <th class="px-8 py-5 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Date</th>
                            <th class="px-8 py-5 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Montant</th>
                            <th class="px-8 py-5 text-[10px] font-bold text-slate-500 uppercase tracking-widest text-center">Statut</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @forelse($sales as $sale)
                            <tr class="hover:bg-white/2 transition-colors">
                                <td class="px-8 py-5">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-lg bg-slate-800 flex items-center justify-center text-lg">📦</div>
                                        <div>
                                            <p class="text-sm font-bold text-white">{{ $sale->product->nom }}</p>
                                            <p class="text-[10px] text-slate-500">ID: #{{ $sale->id }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-5">
                                    <div class="flex items-center gap-2">
                                        <div class="w-6 h-6 rounded bg-linear-to-tr from-purple-500 to-blue-500 flex items-center justify-center text-[8px] font-bold">
                                            {{ substr($sale->buyer->firstname, 0, 1) }}{{ substr($sale->buyer->lastname, 0, 1) }}
                                        </div>
                                        <span class="text-sm text-slate-300">{{ $sale->buyer->pseudo }}</span>
                                    </div>
                                </td>
                                <td class="px-8 py-5">
                                    <span class="text-xs text-slate-400">{{ $sale->created_at->format('d M Y, H:i') }}</span>
                                </td>
                                <td class="px-8 py-5">
                                    <span class="text-sm font-extrabold text-emerald-400">+{{ number_format($sale->amount, 2) }}€</span>
                                </td>
                                <td class="px-8 py-5">
                                    <div class="flex justify-center">
                                        <span class="px-2.5 py-1 rounded-lg bg-emerald-500/10 text-emerald-400 text-[10px] font-bold uppercase border border-emerald-500/20">
                                            Complété
                                        </span>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-8 py-20 text-center">
                                    <div class="text-4xl mb-4 text-slate-800">📉</div>
                                    <p class="text-slate-500 font-medium">Vous n'avez pas encore réalisé de ventes.</p>
                                    <p class="text-[10px] text-slate-600 mt-1 uppercase tracking-widest">Elles apparaîtront ici dès que vos produits seront achetés.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($sales->hasPages())
                <div class="px-8 py-4 border-t border-white/5 bg-white/2">
                    {{ $sales->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
