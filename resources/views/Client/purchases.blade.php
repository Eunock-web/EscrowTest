@extends('layouts.app')

@section('title', 'Mes Achats — PixelVault')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="mb-10">
        <h1 class="font-display text-3xl font-800 text-white mb-2">Mes Achats</h1>
        <p class="text-slate-400">Retrouvez ici l'historique de toutes vos transactions.</p>
    </div>

    @if($purchases->isEmpty())
        <div class="glass p-12 rounded-3xl text-center">
            <div class="w-16 h-16 bg-slate-800 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
            </div>
            <h3 class="text-white font-bold mb-2">Aucun achat pour le moment</h3>
            <p class="text-slate-500 mb-6">Explorez notre boutique pour trouver des produits digitaux premium.</p>
            <a href="{{ route('explorer') }}" class="btn-primary text-white px-8 py-3 rounded-xl font-medium inline-block">
                Explorer
            </a>
        </div>
    @else
        <div class="glass rounded-2xl overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-white/5 bg-white/2">
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-widest">Produit</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-widest">Vendeur</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-widest">Montant</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-widest">Statut</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-widest">Date</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-widest text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @foreach($purchases as $purchase)
                        <tr class="hover:bg-white/1 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-slate-800 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    </div>
                                    <span class="text-sm font-medium text-white">{{ $purchase->product->nom }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-slate-400">{{ $purchase->seller->firstname }} {{ $purchase->seller->lastname }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm font-bold text-white">{{ number_format($purchase->amount, 2) }}€</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 rounded-md text-[10px] font-bold uppercase {{ $purchase->status === 'completed' ? 'bg-emerald-500/10 text-emerald-500' : 'bg-slate-500/10 text-slate-500' }}">
                                    {{ $purchase->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-500">
                                {{ $purchase->created_at->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <button class="text-violet-400 hover:text-violet-300 text-xs font-bold">Télécharger</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
