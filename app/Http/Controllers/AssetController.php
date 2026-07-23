<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssetRequest;
use App\Models\Asset;
use App\Models\Category;
use App\Models\Division;
use App\Models\Location;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AssetController extends Controller
{
    // Fixed order for the 8 PESO divisions — SQLite compatible
    private const DIVISION_ORDER = ['PED','LMISD','ADMIN','SPD','OPM','LRSD','DOC','MSD'];

    private function orderedDivisions()
    {
        // Get all divisions then sort in PHP — works on SQLite and MySQL
        return Division::all()->sortBy(function ($div) {
            $pos = array_search($div->code, self::DIVISION_ORDER);
            return $pos !== false ? $pos : 999;
        })->values();
    }

    public function index(): View
    {
        $assets = Asset::query()
            ->with(['category', 'location', 'division'])
            ->search(request('q'))
            ->when(request('division_id'),  fn($q, $id)   => $q->where('division_id', $id))
            ->when(request('category_id'),  fn($q, $id)   => $q->where('category_id', $id))
            ->when(request('condition'),    fn($q, $cond) => $q->where('condition', $cond))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $stats = [
            'total'     => Asset::count(),
        ];

        return view('assets.index', [
            'assets'     => $assets,
            'divisions'  => $this->orderedDivisions(),
            'categories' => Category::orderBy('name')->get(),
            'stats'      => $stats,
        ]);
    }

    private function formData(): array
    {
        return [
            'categories' => Category::orderBy('name')->get(),
            'locations'  => Location::orderBy('name')->get(),
            'divisions'  => $this->orderedDivisions(),
        ];
    }

    public function create(): View
    {
        return view('assets.create', array_merge($this->formData(), [
            'nextAssetTag' => Asset::nextAssetTag(),
        ]));
    }

    public function store(AssetRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['asset_tag']       = $data['asset_tag'] ?: Asset::nextAssetTag();
        $data['has_crowdstrike'] = $request->boolean('has_crowdstrike');

        Asset::create($data);

        return redirect()->route('assets.index')->with('status', 'Asset created successfully.');
    }

    public function show(Asset $asset): View
    {
        $asset->load(['category', 'location', 'division']);
        return view('assets.show', ['asset' => $asset]);
    }

    public function edit(Asset $asset): View
    {
        return view('assets.edit', array_merge($this->formData(), ['asset' => $asset]));
    }

    public function update(AssetRequest $request, Asset $asset): RedirectResponse
    {
        $data = $request->validated();
        $data['has_crowdstrike'] = $request->boolean('has_crowdstrike');
        $asset->update($data);

        return redirect()->route('assets.index')->with('status', 'Asset updated successfully.');
    }

    public function destroy(Asset $asset): RedirectResponse
    {
        $asset->delete();
        return redirect()->route('assets.index')->with('status', 'Asset deleted successfully.');
    }

    public function bulkDestroy(\Illuminate\Http\Request $request): RedirectResponse
    {
        $ids = $request->input('ids', []);
        if (!empty($ids)) {
            $assets = Asset::whereIn('id', $ids)->get();
            foreach ($assets as $asset) {
                $asset->delete();
            }
            return redirect()->route('assets.index')->with('status', count($ids) . ' assets deleted successfully.');
        }
        return redirect()->route('assets.index')->with('error', 'No assets selected.');
    }

    public function bulkForceDelete(\Illuminate\Http\Request $request): RedirectResponse
    {
        $ids = $request->input('ids', []);
        if (!empty($ids)) {
            $assets = Asset::onlyTrashed()->whereIn('id', $ids)->get();
            foreach ($assets as $asset) {
                $asset->forceDelete();
            }
            return redirect()->route('assets.trash')->with('status', count($ids) . ' assets permanently deleted.');
        }
        return redirect()->route('assets.trash')->with('error', 'No assets selected.');
    }

    public function export(): StreamedResponse
    {
        $assets = Asset::query()
            ->with(['category', 'location', 'division'])
            ->search(request('q'))
            ->status(request('status'))
            ->when(request('division_id'), fn($q, $id) => $q->where('division_id', $id))
            ->when(request('category_id'), fn($q, $id) => $q->where('category_id', $id))
            ->latest()->get();

        $filename = 'assets-export-'.now()->format('Y-m-d_His').'.csv';
        $headers  = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($assets) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, [
                'Asset Tag','Name','Equipment Type','Location','Division',
                'Model','Serial Number','Status','Condition',
                'CPU','RAM (Total)','RAM (Used)','Storage',
                'OS','Utilized By','Ownership','Connectivity',
                'WiFi Network','CrowdStrike','Software Installed',
            ]);
            foreach ($assets as $a) {
                fputcsv($handle, [
                    $a->asset_tag, $a->name,
                    $a->category->name,
                    $a->location?->name,
                    $a->division ? ($a->division->code.' - '.$a->division->name) : null,
                    $a->model, $a->serial_number,
                    $a->status, $a->condition,
                    $a->cpu, $a->ram_total, $a->ram_used,
                    $a->storage_capacity,
                    $a->operating_system, $a->utilized_by,
                    $a->ownership_type, $a->connectivity, $a->wifi_network,
                    $a->has_crowdstrike ? 'YES' : 'NO',
                    $a->software_installed,
                ]);
            }
            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function trash(): View
    {
        $assets = Asset::onlyTrashed()
            ->with(['category', 'location', 'division'])
            ->latest('deleted_at')->paginate(15);
        return view('assets.trash', ['assets' => $assets]);
    }

    public function restore(int $assetId): RedirectResponse
    {
        Asset::onlyTrashed()->findOrFail($assetId)->restore();
        return redirect()->route('assets.trash')->with('status', 'Asset restored successfully.');
    }

    public function forceDelete(int $assetId): RedirectResponse
    {
        Asset::onlyTrashed()->findOrFail($assetId)->forceDelete();
        return redirect()->route('assets.trash')->with('status', 'Asset permanently deleted.');
    }

    public function label(Asset $asset): View
{
    $asset->load(['category', 'location', 'division']);
    return view('assets.label', ['asset' => $asset]);
    }

    public function lookup(string $tag): View
    {

    $asset = Asset::where('asset_tag', $tag)
        ->with(['category', 'location', 'division'])
        ->firstOrFail();
    return view('assets.lookup', ['asset' => $asset]);
    }

}

