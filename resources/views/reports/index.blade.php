@extends('layouts.app')

@section('title', 'Reports')
@section('subtitle', 'Inventory analytics and summary')

@section('content')

<div class="grid grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-100">
        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide mb-1">Total Asset Value</p>
        <p class="text-2xl font-bold text-slate-800">&#8369;{{ number_format($totalValue, 2) }}</p>
        <p class="text-xs text-slate-400 mt-1">Avg &#8369;{{ number_format($avgValue ?? 0, 2) }} per unit</p>
    </div>
    <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-100">
        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide mb-1">CrowdStrike Coverage</p>
        @php $pct = $totalComputers > 0 ? round(($withCrowdStrike / $totalComputers) * 100) : 0; @endphp
        <p class="text-2xl font-bold {{ $pct >= 80 ? 'text-green-600' : 'text-red-600' }}">{{ $pct }}%</p>
        <p class="text-xs text-slate-400 mt-1">{{ $withCrowdStrike }} / {{ $totalComputers }} computers</p>
    </div>
    <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-100">
        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide mb-1">Warranty Alerts</p>
        <p class="text-2xl font-bold text-amber-600">{{ $warrantyExpired->count() + $warrantyExpiring30->count() }}</p>
        <p class="text-xs text-slate-400 mt-1">{{ $warrantyExpired->count() }} expired &middot; {{ $warrantyExpiring30->count() }} due in 30d</p>
    </div>
    <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-100">
        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide mb-1">Open Maintenance</p>
        <p class="text-2xl font-bold text-blue-600">{{ $openTickets + $inProgressTickets }}</p>
        <p class="text-xs text-slate-400 mt-1">Avg {{ $avgResolutionDays ? round($avgResolutionDays, 1).'d' : 'N/A' }} to resolve</p>
    </div>
</div>

<div class="grid grid-cols-3 gap-5 mb-5">
    <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-5">
        <h3 class="font-bold text-slate-800 text-sm mb-4">Assets by Status</h3>
        <canvas id="statusChart" height="200"></canvas>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-5">
        <h3 class="font-bold text-slate-800 text-sm mb-4">Assets by Division</h3>
        <canvas id="divisionChart" height="200"></canvas>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-5">
        <h3 class="font-bold text-slate-800 text-sm mb-4">Assets by Condition</h3>
        <canvas id="conditionChart" height="200"></canvas>
    </div>
</div>

<div class="grid grid-cols-2 gap-5 mb-5">
    <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-5">
        <h3 class="font-bold text-slate-800 text-sm mb-4">Assets by Equipment Type</h3>
        <canvas id="categoryChart" height="180"></canvas>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-5">
        <h3 class="font-bold text-slate-800 text-sm mb-4">Operating System Distribution</h3>
        <canvas id="osChart" height="180"></canvas>
    </div>
</div>

<div class="grid grid-cols-2 gap-5 mb-5">
    <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-5">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-bold text-slate-800 text-sm">Warranty Expired</h3>
            <span class="text-xs bg-red-100 text-red-700 px-2 py-0.5 rounded-full font-semibold">{{ $warrantyExpired->count() }}</span>
        </div>
        @forelse ($warrantyExpired->take(8) as $asset)
        <div class="flex items-center justify-between py-2 border-b border-slate-100 last:border-0">
            <div>
                <span class="font-mono text-xs font-bold text-slate-700">{{ $asset->asset_tag }}</span>
                @if ($asset->division)
                <span class="ml-1 text-xs bg-blue-50 text-blue-700 px-1.5 py-0.5 rounded font-bold">{{ $asset->division->code }}</span>
                @endif
                <p class="text-xs text-slate-500">{{ $asset->name }}</p>
            </div>
            <span class="text-xs font-semibold text-red-600">{{ $asset->warranty_expiry->format('M d, Y') }}</span>
        </div>
        @empty
        <p class="text-sm text-slate-400 text-center py-4">No expired warranties.</p>
        @endforelse
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-5">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-bold text-slate-800 text-sm">Expiring in 30 Days</h3>
            <span class="text-xs bg-amber-100 text-amber-700 px-2 py-0.5 rounded-full font-semibold">{{ $warrantyExpiring30->count() }}</span>
        </div>
        @forelse ($warrantyExpiring30->take(8) as $asset)
        <div class="flex items-center justify-between py-2 border-b border-slate-100 last:border-0">
            <div>
                <span class="font-mono text-xs font-bold text-slate-700">{{ $asset->asset_tag }}</span>
                @if ($asset->division)
                <span class="ml-1 text-xs bg-blue-50 text-blue-700 px-1.5 py-0.5 rounded font-bold">{{ $asset->division->code }}</span>
                @endif
                <p class="text-xs text-slate-500">{{ $asset->name }}</p>
            </div>
            <span class="text-xs font-semibold text-amber-600">{{ $asset->warranty_expiry->format('M d, Y') }}</span>
        </div>
        @empty
        <p class="text-sm text-slate-400 text-center py-4">Nothing expiring soon.</p>
        @endforelse
    </div>
</div>

<div class="text-right">
    <button onclick="window.print()" class="inline-flex items-center gap-2 text-sm font-medium px-4 py-2 border border-slate-200 rounded-lg hover:bg-slate-50">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
        Print Report
    </button>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
<script>
var p=['#0d2a5e','#1a3a7c','#2563eb','#3b82f6','#60a5fa','#f5c518','#f59e0b','#ef4444','#22c55e','#a855f7'];
new Chart(document.getElementById('statusChart'),{type:'doughnut',data:{labels:{!! json_encode($byStatus->keys()->map(fn($s)=>ucfirst(str_replace('_',' ',$s)))->values()) !!},datasets:[{data:{!! json_encode($byStatus->values()) !!},backgroundColor:p,borderWidth:2,borderColor:'#fff'}]},options:{plugins:{legend:{position:'bottom',labels:{font:{size:11}}}},cutout:'60%'}});
new Chart(document.getElementById('divisionChart'),{type:'bar',data:{labels:{!! json_encode($byDivision->pluck('label')) !!},datasets:[{label:'Assets',data:{!! json_encode($byDivision->pluck('count')) !!},backgroundColor:'#1a3a7c',borderRadius:6}]},options:{plugins:{legend:{display:false}},scales:{y:{beginAtZero:true,ticks:{stepSize:1}}}}});
new Chart(document.getElementById('conditionChart'),{type:'doughnut',data:{labels:{!! json_encode($byCondition->keys()->map(fn($c)=>ucfirst(str_replace('_',' ',$c)))->values()) !!},datasets:[{data:{!! json_encode($byCondition->values()) !!},backgroundColor:['#22c55e','#f59e0b','#f97316','#ef4444'],borderWidth:2,borderColor:'#fff'}]},options:{plugins:{legend:{position:'bottom',labels:{font:{size:11}}}},cutout:'60%'}});
new Chart(document.getElementById('categoryChart'),{type:'bar',data:{labels:{!! json_encode($byCategory->pluck('label')) !!},datasets:[{label:'Count',data:{!! json_encode($byCategory->pluck('count')) !!},backgroundColor:'#3b82f6',borderRadius:6}]},options:{indexAxis:'y',plugins:{legend:{display:false}},scales:{x:{beginAtZero:true,ticks:{stepSize:1}}}}});
new Chart(document.getElementById('osChart'),{type:'bar',data:{labels:{!! json_encode($byOS->pluck('label')) !!},datasets:[{label:'Count',data:{!! json_encode($byOS->pluck('count')) !!},backgroundColor:'#f5c518',borderRadius:6}]},options:{indexAxis:'y',plugins:{legend:{display:false}},scales:{x:{beginAtZero:true,ticks:{stepSize:1}}}}});
</script>
<style>@media print{aside,header,footer,button{display:none!important}.ml-60{margin-left:0!important}}</style>
@endsection