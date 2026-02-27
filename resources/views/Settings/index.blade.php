@extends('layouts.app')

@section('title', 'PixelVault — Paramètres')

@section('content')
    <div class="animate-fade">
        <div class="mb-10">
            <h1 class="text-4xl font-extrabold text-white mb-2">Paramètres du <span class="g">profil</span></h1>
            <p class="text-slate-500">Gérez vos informations personnelles et votre présence sur la plateforme.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Form Side -->
            <div class="lg:col-span-2 space-y-6">
                <form id="profileForm" class="space-y-6">
                    @csrf
                    <!-- Identity Section -->
                    <div class="glass p-8 rounded-3xl border-white/5 relative overflow-hidden">
                        <div class="absolute top-0 left-0 w-full h-1 bg-linear-to-r from-purple-500 to-blue-500"></div>
                        <h3 class="text-xl font-bold text-white mb-6 flex items-center gap-3">
                            <span class="p-2 bg-purple-500/10 rounded-lg text-purple-400">👤</span>
                            Identité & Pseudo
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Prénom</label>
                                <input type="text" name="firstname" value="{{ $user->firstname }}" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-purple-500/50 focus:ring-0 outline-none transition-all">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Nom</label>
                                <input type="text" name="lastname" value="{{ $user->lastname }}" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-purple-500/50 focus:ring-0 outline-none transition-all">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Pseudo public</label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-purple-400 font-bold">@</span>
                                    <input type="text" name="pseudo" value="{{ $user->pseudo }}" class="w-full bg-white/5 border border-white/10 rounded-xl pl-10 pr-4 py-3 text-white focus:border-purple-500/50 focus:ring-0 outline-none transition-all">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Profession Section -->
                    <div class="glass p-8 rounded-3xl border-white/5">
                        <h3 class="text-xl font-bold text-white mb-6 flex items-center gap-3">
                            <span class="p-2 bg-blue-500/10 rounded-lg text-blue-400">🎨</span>
                            Expertise & Biographie
                        </h3>
                        
                        <div class="space-y-6">
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Spécialité (ex: Designer UI, Développeur Laravel)</label>
                                <input type="text" name="specialite" value="{{ $user->specialite }}" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-purple-500/50 focus:ring-0 outline-none transition-all">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Ma Biographie</label>
                                <textarea name="description" rows="4" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-purple-500/50 focus:ring-0 outline-none transition-all resize-none">{{ $user->description }}</textarea>
                                <p class="text-[10px] text-slate-500 mt-2">Dites à vos clients qui vous êtes et ce que vous créez.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Section -->
                    <div class="glass p-8 rounded-3xl border-white/5">
                        <h3 class="text-xl font-bold text-white mb-6 flex items-center gap-3">
                            <span class="p-2 bg-cyan-500/10 rounded-lg text-cyan-400">📧</span>
                            Contact
                        </h3>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Email</label>
                            <input type="email" name="email" value="{{ $user->email }}" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-purple-500/50 focus:ring-0 outline-none transition-all">
                        </div>
                    </div>

                    <div class="flex justify-end pt-4">
                        <button type="submit" id="saveBtn" class="px-10 py-4 bg-linear-to-r from-purple-600 to-blue-600 hover:from-purple-500 hover:to-blue-500 text-white font-bold rounded-2xl shadow-xl shadow-purple-500/20 transition-all flex items-center gap-3 group">
                            Sauvegarder les modifications
                            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Preview Side -->
            <div class="space-y-6">
                <div class="glass p-8 rounded-3xl border-white/5 sticky top-8 text-center">
                    <h4 class="text-sm font-bold text-slate-500 uppercase tracking-widest mb-8">Aperçu Public</h4>
                    
                    <div class="w-32 h-32 rounded-3xl bg-linear-to-tr from-purple-500 to-blue-500 mx-auto flex items-center justify-center text-4xl font-bold shadow-2xl shadow-purple-500/30 mb-6 ring-4 ring-white/5">
                        {{ substr($user->firstname, 0, 1) }}{{ substr($user->lastname, 0, 1) }}
                    </div>
                    
                    <h3 class="text-2xl font-bold text-white mb-1">{{ $user->firstname }} {{ $user->lastname }}</h3>
                    <p class="text-purple-400 font-medium mb-6">@ {{ $user->pseudo }}</p>
                    
                    <div class="flex justify-center gap-2 mb-8">
                        <span class="px-3 py-1 bg-purple-500/20 text-purple-300 border border-purple-500/30 rounded-lg text-xs font-bold uppercase">
                            {{ $user->specialite ?? 'Généraliste' }}
                        </span>
                    </div>

                    <div class="p-4 rounded-2xl bg-white/5 border border-white/5 mb-8">
                        <p class="text-xs text-slate-500 uppercase tracking-widest font-bold mb-2">Ma Bio</p>
                        <p class="text-sm text-slate-300 leading-relaxed italic">
                            "{{ $user->description ?? 'Pas de bio encore...' }}"
                        </p>
                    </div>

                    <button class="w-full py-3 bg-white/5 border border-white/10 text-white text-xs font-bold rounded-xl hover:bg-white/10 transition-all">
                        Voir mon profil public
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    document.getElementById('profileForm').addEventListener('submit', async (e) => {
        e.preventDefault();
        const btn = document.getElementById('saveBtn');
        const originalText = btn.innerHTML;
        
        btn.disabled = true;
        btn.innerHTML = '<span class="animate-spin text-xl">🌀</span> Traitement...';

        const formData = new FormData(e.target);

        try {
            const response = await fetch("{{ route('settings.update') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'Accept': 'application/json'
                },
                body: formData
            });

            const data = await response.json();

            if (response.ok) {
                alert(data.message);
                location.reload();
            } else {
                alert('Erreur: ' + (data.message || 'Une erreur est survenue.'));
            }
        } catch (error) {
            console.error(error);
            alert('Une erreur réseau est survenue.');
        } finally {
            btn.disabled = false;
            btn.innerHTML = originalText;
        }
    });
</script>
@endsection
