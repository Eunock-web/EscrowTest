@extends('layouts.app')

@section('title', 'PixelVault — Analytics')

@section('content')
    <div class="animate-fade">
        <div class="mb-10">
            <h1 class="text-4xl font-extrabold text-white mb-2">Analytics & <span class="g">Performances</span></h1>
            <p class="text-slate-500">Suivez l'évolution de votre activité de créateur en temps réel.</p>
        </div>

        <!-- KPI Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
            <div class="glass p-8 rounded-3xl relative overflow-hidden group">
                <div class="absolute -right-6 -top-6 w-32 h-32 bg-purple-600/10 rounded-full blur-3xl group-hover:bg-purple-600/20 transition-all"></div>
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl bg-purple-500/10 flex items-center justify-center text-purple-400">📊</div>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-widest">Revenus</p>
                </div>
                <h3 class="text-4xl font-extrabold text-white mb-1">{{ number_format($totalRevenue, 2) }}<span class="g">€</span></h3>
                <p class="text-[10px] text-slate-500">Total accumulé</p>
            </div>

            <div class="glass p-8 rounded-3xl relative overflow-hidden group">
                <div class="absolute -right-6 -top-6 w-32 h-32 bg-blue-600/10 rounded-full blur-3xl group-hover:bg-blue-600/20 transition-all"></div>
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl bg-blue-500/10 flex items-center justify-center text-blue-400">⚡</div>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-widest">Ventes</p>
                </div>
                <h3 class="text-4xl font-extrabold text-white mb-1">{{ $totalSales }}</h3>
                <p class="text-[10px] text-slate-500">Nombre de transactions</p>
            </div>

            <div class="glass p-8 rounded-3xl relative overflow-hidden group">
                <div class="absolute -right-6 -top-6 w-32 h-32 bg-cyan-600/10 rounded-full blur-3xl group-hover:bg-cyan-600/20 transition-all"></div>
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl bg-cyan-500/10 flex items-center justify-center text-cyan-400">👁️</div>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-widest">Vues</p>
                </div>
                <h3 class="text-4xl font-extrabold text-white mb-1">{{ $totalViews }}</h3>
                <p class="text-[10px] text-slate-500">Visites sur vos pages</p>
            </div>

            <div class="glass p-8 rounded-3xl relative overflow-hidden group">
                <div class="absolute -right-6 -top-6 w-32 h-32 bg-orange-600/10 rounded-full blur-3xl group-hover:bg-orange-600/20 transition-all"></div>
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl bg-orange-500/10 flex items-center justify-center text-orange-400">📦</div>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-widest">Produits</p>
                </div>
                <h3 class="text-4xl font-extrabold text-white mb-1">{{ $totalProducts }}</h3>
                <p class="text-[10px] text-slate-500">Actuellement en ligne</p>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-10">
            <div class="lg:col-span-2 glass p-8 rounded-3xl border-white/5">
                <div class="flex items-center justify-between mb-8">
                    <h4 class="text-xl font-bold text-white">Évolution des ventes</h4>
                    <select class="bg-white/5 border border-white/10 rounded-lg px-3 py-1.5 text-[10px] font-bold text-white outline-none">
                        <option>7 derniers jours</option>
                        <option>30 derniers jours</option>
                        <option>Cette année</option>
                    </select>
                </div>
                <div class="h-[300px] w-full relative">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>

            <div class="glass p-8 rounded-3xl border-white/5">
                <h4 class="text-xl font-bold text-white mb-8">Répartition Catégories</h4>
                <div class="h-[250px] w-full relative flex items-center justify-center">
                    <canvas id="categoryChart"></canvas>
                </div>
                <div class="mt-8 space-y-3">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-purple-500"></span>
                            <span class="text-xs text-slate-400">UI Kits</span>
                        </div>
                        <span class="text-xs font-bold text-white">45%</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                            <span class="text-xs text-slate-400">Templates</span>
                        </div>
                        <span class="text-xs font-bold text-white">35%</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-cyan-500"></span>
                            <span class="text-xs text-slate-400">Plugins</span>
                        </div>
                        <span class="text-xs font-bold text-white">20%</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Sales Evolution Chart
    const ctx = document.getElementById('salesChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'],
            datasets: [{
                label: 'Ventes',
                data: [12, 19, 15, 25, 22, 30, 28],
                borderColor: '#7c3aed',
                backgroundColor: 'rgba(124, 58, 237, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#7c3aed',
                pointBorderColor: 'rgba(255,255,255,0.2)',
                pointBorderWidth: 4,
                pointRadius: 6,
                pointHoverRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(255,255,255,0.03)' },
                    ticks: { color: '#64748b', font: { size: 10 } }
                },
                x: {
                    grid: { display: false },
                    ticks: { color: '#64748b', font: { size: 10 } }
                }
            }
        }
    });

    // Category Distribution Chart
    const cctx = document.getElementById('categoryChart').getContext('2d');
    new Chart(cctx, {
        type: 'doughnut',
        data: {
            labels: ['UI Kits', 'Templates', 'Plugins'],
            datasets: [{
                data: [45, 35, 20],
                backgroundColor: ['#7c3aed', '#3b82f6', '#06b6d4'],
                borderWidth: 0,
                hoverOffset: 10
            }]
        },
        options: {
            cutout: '80%',
            plugins: {
                legend: { display: false }
            }
        }
    });
</script>
@endsection
