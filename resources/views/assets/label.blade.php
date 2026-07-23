<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Label — {{ $asset->asset_tag }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            body { margin: 0; }
            .no-print { display: none !important; }
            .label { page-break-inside: avoid; }
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col items-center justify-center p-8">

    <div class="no-print mb-6 flex gap-3">
        <button onclick="window.print()" class="px-4 py-2 text-sm font-semibold text-white rounded-lg" style="background:#0d2a5e;">
            Print Label
        </button>
        <a href="{{ route('assets.show', $asset) }}" class="px-4 py-2 text-sm font-medium border border-slate-200 rounded-lg bg-white hover:bg-slate-50">
            Back to Asset
        </a>
    </div>

    <div class="label bg-white rounded-xl shadow-lg p-6 w-80 border-2 border-slate-200">

        {{-- Header --}}
        <div class="flex items-center gap-3 mb-4 pb-3 border-b border-slate-100">
            <img src="{{ asset('images/logo.png') }}" alt="QC PESO" class="w-10 h-10 object-contain rounded-full bg-white border border-slate-100">
            <div>
                <p class="font-bold text-slate-800 text-sm">QC PESO CMIS</p>
                <p class="text-xs text-slate-400">Equipment Asset Label</p>
            </div>
        </div>

        {{-- Asset Info --}}
        <div class="text-center mb-4">
            <p class="font-mono font-bold text-xl text-slate-800 tracking-wider">{{ $asset->asset_tag }}</p>
            <p class="text-sm font-semibold text-slate-700 mt-1">{{ $asset->name }}</p>
            <p class="text-xs text-slate-400">{{ $asset->model }}</p>
        </div>

        <div class="space-y-1.5 text-xs border-t border-slate-100 pt-3">
            @if ($asset->division)
            <div class="flex justify-between">
                <span class="text-slate-400">Division</span>
                <span class="font-semibold text-slate-700">{{ $asset->division->code }} — {{ $asset->division->name }}</span>
            </div>
            @endif
            @if ($asset->utilized_by)
            <div class="flex justify-between">
                <span class="text-slate-400">Utilized by</span>
                <span class="font-semibold text-slate-700">{{ $asset->utilized_by }}</span>
            </div>
            @endif
            @if ($asset->serial_number)
            <div class="flex justify-between">
                <span class="text-slate-400">Serial No.</span>
                <span class="font-mono font-semibold text-slate-700">{{ $asset->serial_number }}</span>
            </div>
            @endif
            <div class="flex justify-between">
                <span class="text-slate-400">Status</span>
                <span class="font-semibold text-slate-700">{{ ucfirst(str_replace('_', ' ', $asset->status)) }}</span>
            </div>
        </div>

        <p class="text-center text-xs text-slate-300 mt-3">Scan QR to view full record</p>
    </div>

    <script>
        new QRCode(document.getElementById('qrcode'), {
            text: '{{ url('/assets/lookup/' . $asset->asset_tag) }}',
            width: 150,
            height: 150,
            colorDark: '#0d2a5e',
            colorLight: '#ffffff',
        });
    </script>
</body>
</html>