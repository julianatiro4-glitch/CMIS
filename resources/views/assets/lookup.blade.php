<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $asset->asset_tag }} — QC PESO CMIS</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-sm">

        <div class="text-center mb-5">
            <img src="{{ asset('images/logo.png') }}" alt="QC PESO" class="w-14 h-14 rounded-full mx-auto mb-2 bg-white p-1 border border-slate-200 object-contain">
            <p class="font-bold text-slate-800">QC PESO CMIS</p>
            <p class="text-xs text-slate-400">Asset Quick Lookup</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">

            {{-- Tag header --}}
            <div class="px-5 py-4 text-center" style="background:#0d2a5e;">
                <p class="font-mono font-bold text-2xl text-white tracking-widest">{{ $asset->asset_tag }}</p>
                <p class="text-blue-200 text-sm mt-0.5">{{ $asset->name }}</p>
                <p class="text-blue-300 text-xs">{{ $asset->model }}</p>
            </div>

            {{-- Condition badge --}}
            @php
            $conditionColors = ['good'=>'bg-green-100 text-green-700','fair'=>'bg-yellow-100 text-yellow-700','for_repair'=>'bg-orange-100 text-orange-700','unserviceable'=>'bg-red-100 text-red-700'];
            @endphp
            <div class="px-5 py-3 border-b border-slate-100 flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-500">Status</span>
                <span class="px-3 py-1 rounded-full text-xs font-bold {{ $conditionColors[$asset->condition ?? 'good'] ?? 'bg-slate-100 text-slate-500' }}">
                    {{ ucfirst(str_replace('_', ' ', $asset->condition ?? 'good')) }}
                </span>
            </div>

            {{-- Details --}}
            <div class="px-5 py-4 space-y-3">
                @if ($asset->division)
                <div class="flex justify-between text-sm">
                    <span class="text-slate-400">Division</span>
                    <span class="font-semibold text-slate-800">
                        <span class="font-mono text-xs bg-blue-50 text-blue-700 px-1.5 py-0.5 rounded mr-1">{{ $asset->division->code }}</span>
                        {{ $asset->division->name }}
                    </span>
                </div>
                @endif
                @if ($asset->utilized_by)
                <div class="flex justify-between text-sm">
                    <span class="text-slate-400">Utilized By</span>
                    <span class="font-semibold text-slate-800">{{ $asset->utilized_by }}</span>
                </div>
                @endif

                @if ($asset->cpu)
                <div class="flex justify-between text-sm">
                    <span class="text-slate-400">CPU</span>
                    <span class="font-semibold text-slate-800 text-right max-w-48">{{ $asset->cpu }}</span>
                </div>
                @endif
                @if ($asset->ram_total)
                <div class="flex justify-between text-sm">
                    <span class="text-slate-400">RAM</span>
                    <span class="font-semibold text-slate-800">{{ $asset->ram_total }}</span>
                </div>
                @endif
                @if ($asset->operating_system)
                <div class="flex justify-between text-sm">
                    <span class="text-slate-400">OS</span>
                    <span class="font-semibold text-slate-800">{{ $asset->operating_system }}</span>
                </div>
                @endif
                @if ($asset->serial_number)
                <div class="flex justify-between text-sm">
                    <span class="text-slate-400">Serial No.</span>
                    <span class="font-mono font-semibold text-slate-800">{{ $asset->serial_number }}</span>
                </div>
                @endif

            </div>

            <div class="px-5 pb-5">
                <p class="text-xs text-slate-300 text-center">Scanned {{ now()->format('M d, Y H:i') }}</p>
            </div>
        </div>

    </div>
</body>
</html>