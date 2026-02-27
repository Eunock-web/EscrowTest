@extends('layouts.app')

@section('title', 'Utilisateurs — Administration')

@section('content')
    <header class="flex items-center justify-between mb-10">
        <div>
            <h2 class="text-3xl font-extrabold text-white">Gestion des Utilisateurs</h2>
            <p class="text-slate-500 mt-1">Liste complète des membres inscrits sur PixelVault.</p>
        </div>
    </header>

    <div class="glass rounded-3xl overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-white/5">
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-widest">Utilisateur</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-widest">Rôle</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-widest">Description</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-widest text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @foreach($users as $user)
                    <tr class="hover:bg-white/[0.02] transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-slate-800 flex items-center justify-center font-bold text-white">
                                    {{ substr($user->firstname, 0, 1) }}
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-white">{{ $user->pseudo }}</p>
                                    <p class="text-xs text-slate-500">{{ $user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded-md text-[10px] font-bold uppercase border {{ $user->role === 'admin' ? 'text-red-400 border-red-400/20 bg-red-400/10' : ($user->role === 'createur' ? 'text-purple-400 border-purple-400/20 bg-purple-400/10' : 'text-blue-400 border-blue-400/20 bg-blue-400/10') }}">
                                {{ $user->role }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-xs text-slate-400 max-w-xs truncate">{{ $user->description ?? 'N/A' }}</p>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <button class="text-xs font-bold text-slate-500 hover:text-white transition-colors">Éditer</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
        <div class="p-6 border-t border-white/5">
            {{ $users->links() }}
        </div>
    </div>
@endsection
