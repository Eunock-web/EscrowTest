@extends('layouts.app')

@section('title', 'Modifier l' . "'" . 'Utilisateur — Administration')

@section('content')
    <header class="flex items-center justify-between mb-10">
        <div>
            <h2 class="text-3xl font-extrabold text-white">Modifier l'Utilisateur</h2>
            <p class="text-slate-500 mt-1">Gérer les informations et le rôle de l'utilisateur.</p>
        </div>
        <a href="{{ route('admin.users') }}" class="text-sm font-bold text-slate-400 hover:text-white transition-colors">
            &larr; Retour à la liste
        </a>
    </header>

    <div class="glass p-8 rounded-3xl max-w-2xl">
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label class="block text-sm font-bold text-slate-400 mb-2">Pseudo</label>
                <input type="text" name="pseudo" value="{{ old('pseudo', $user->pseudo) }}" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-violet-500" required>
                @error('pseudo')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-bold text-slate-400 mb-2">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-violet-500" required>
                @error('email')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-bold text-slate-400 mb-2">Rôle</label>
                <select name="role" class="w-full bg-slate-900 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-violet-500" required>
                    <option value="client" {{ $user->role === 'client' ? 'selected' : '' }}>Client</option>
                    <option value="createur" {{ $user->role === 'createur' ? 'selected' : '' }}>Créateur</option>
                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
                @error('role')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="mb-8">
                <label class="block text-sm font-bold text-slate-400 mb-2">Description</label>
                <textarea name="description" rows="4" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-violet-500">{{ old('description', $user->description) }}</textarea>
                @error('description')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="flex justify-end gap-4">
                <a href="{{ route('admin.users') }}" class="px-6 py-3 rounded-xl font-bold text-slate-400 hover:text-white transition-colors border border-white/10 hover:bg-white/5">
                    Annuler
                </a>
                <button type="submit" class="bg-violet-600 hover:bg-violet-700 text-white font-bold py-3 px-6 rounded-xl transition-colors shadow-[0_0_15px_rgba(124,58,237,0.4)]">
                    Enregistrer les modifications
                </button>
            </div>
        </form>
    </div>
@endsection
