@extends('layouts.app')

@section('title', 'Analytics — Administration')

@section('content')
    <div class="animate-fade">
        <div class="mb-10">
            <h1 class="text-4xl font-extrabold text-white mb-2">Platform <span class="g">Analytics</span></h1>
            <p class="text-slate-500">Global oversight of PixelVault's growth and performance.</p>
        </div>

        <!-- KPI Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
            <div class="glass p-8 rounded-3xl group transition-all hover:bg-white/[0.05]">
                <p class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-4">Volume d'Affaire</p>
                <h3 class="text-4xl font-extrabold text-white mb-1">{{ number_format($stats['totalRevenue'], 2) }}€</h3>
                <p class="text-[10px] text-emerald-400 font-bold">Total Platform Revenue</p>
            </div>
            <div class="glass p-8 rounded-3xl group transition-all hover:bg-white/[0.05]">
                <p class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-4">Base Utilisateurs</p>
                <h3 class="text-4xl font-extrabold text-white mb-1">{{ $stats['totalUsers'] }}</h3>
                <p class="text-[10px] text-purple-400 font-bold">Total Registered users</p>
            </div>
            <div class="glass p-8 rounded-3xl group transition-all hover:bg-white/[0.05]">
                <p class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-4">Actifs Numériques</p>
                <h3 class="text-4xl font-extrabold text-white mb-1">{{ $stats['totalProducts'] }}</h3>
                <p class="text-[10px] text-blue-400 font-bold">Products listed</p>
            </div>
            <div class="glass p-8 rounded-3xl group transition-all hover:bg-white/[0.05]">
                <p class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-4">Transactions</p>
                <h3 class="text-4xl font-extrabold text-white mb-1">{{ $stats['totalSales'] }}</h3>
                <p class="text-[10px] text-orange-400 font-bold">Completed sales</p>
            </div>
        </div>

        <!-- Charts Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-10">
            <div class="glass p-8 rounded-3xl border border-white/5">
                <h4 class="text-xl font-bold text-white mb-8">Croissance des Revenus</h4>
                <div class="h-[350px]">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>
            <div class="glass p-8 rounded-3xl border border-white/5">
                <h4 class="text-xl font-bold text-white mb-8">Acquisition Utilisateurs</h4>
                <div class="h-[350px]">
                    <canvas id="userGrowthChart"></canvas>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-10">
            <div class="lg:col-span-1 glass p-8 rounded-3xl border border-white/5">
                <h4 class="text-xl font-bold text-white mb-8">Distribution Marché</h4>
                <div class="h-[300px] flex items-center justify-center">
                    <canvas id="categoryChart"></canvas>
                </div>
            </div>
            <div class="lg:col-span-2 glass p-8 rounded-3xl border border-white/5">
                <h4 class="text-xl font-bold text-white mb-8">Performances Mensuelles</h4>
                <div class="space-y-6">
                    @foreach($monthlyRevenue as $rev)
                        <div class="flex items-center justify-between">
                            <div class="flex flex-col">
                                <span class="text-sm font-bold text-white uppercase tracking-tight">{{ trim($rev->month) }}</span>
                                <span class="text-[10px] text-slate-500">Revenus mensuels</span>
                            </div>
                            <div class="flex items-center gap-4">
                                <span class="text-sm font-extrabold text-emerald-400">{{ number_format($rev->total, 2) }}€</span>
                                <div class="w-32 bg-white/5 h-1.5 rounded-full overflow-hidden">
                                    <div class="bg-emerald-500 h-full" style="width: {{ ($rev->total / max($monthlyRevenue->pluck('total')->toArray() ?: [1])) * 100 }}%"></div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    Chart.defaults.color = '#64748b';
    Chart.defaults.font.family = "'Inter', sans-serif";

    // Revenue Chart
    new Chart(document.getElementById('revenueChart'), {
        type: 'line',
        data: {
            labels: {!! json_encode($monthlyRevenue->pluck('month')->map(fn($m) => trim($m))) !!},
            datasets: [{
                label: 'Revenus (€)',
                data: {!! json_encode($monthlyRevenue->pluck('total')) !!},
                borderColor: '#10b981',
                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                borderWidth: 4,
                tension: 0.4,
                fill: true,
                pointBackgroundColor: '#10b981',
                pointRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { grid: { color: 'rgba(255,255,255,0.03)' } },
                x: { grid: { display: false } }
            }
        }
    });

    // User Growth Chart
    new Chart(document.getElementById('userGrowthChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($userGrowth->pluck('month')->map(fn($m) => trim($m))) !!},
            datasets: [{
                label: 'Inscriptions',
                data: {!! json_encode($userGrowth->pluck('count')) !!},
                backgroundColor: '#7c3aed',
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { grid: { color: 'rgba(255,255,255,0.03)' } },
                x: { grid: { display: false } }
            }
        }
    });

    // Category Distribution
    new Chart(document.getElementById('categoryChart'), {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($categoryDistribution->pluck('nom')) !!},
            datasets: [{
                data: {!! json_encode($categoryDistribution->pluck('count')) !!},
                backgroundColor: ['#7c3aed', '#3b82f6', '#06b6d4', '#10b981', '#f59e0b', '#ef4444'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '75%',
            plugins: {
                legend: { position: 'bottom', labels: { padding: 20, boxWidth: 10, font: { size: 10 } } }
            }
        }
    });
</script>
@endsection
