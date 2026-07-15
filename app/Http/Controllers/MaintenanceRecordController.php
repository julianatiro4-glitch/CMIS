<?php

namespace App\Http\Controllers;

use App\Http\Requests\MaintenanceRecordRequest;
use App\Models\Asset;
use App\Models\MaintenanceRecord;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class MaintenanceRecordController extends Controller
{
    public function index(): View
    {
        $records = MaintenanceRecord::with('asset')
            ->latest('opened_at')
            ->paginate(15);

        return view('maintenance.index', ['records' => $records]);
    }

    public function create(): View
    {
        return view('maintenance.create', [
            'assets' => Asset::orderBy('name')->get(),
        ]);
    }

    public function store(MaintenanceRecordRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['reported_by'] = $request->user()?->id;

        MaintenanceRecord::create($data);

        Asset::where('id', $data['asset_id'])->update(['status' => 'in_repair']);

        return redirect()->route('maintenance.index')->with('status', 'Maintenance ticket opened.');
    }

    public function edit(MaintenanceRecord $maintenance): View
    {
        return view('maintenance.edit', [
            'record' => $maintenance,
            'assets' => Asset::orderBy('name')->get(),
        ]);
    }

    public function update(MaintenanceRecordRequest $request, MaintenanceRecord $maintenance): RedirectResponse
    {
        $data = $request->validated();

        if ($data['status'] === 'resolved' && ! $maintenance->resolved_at) {
            $data['resolved_at'] = now();
        }

        $maintenance->update($data);

        if ($data['status'] === 'resolved') {
            $maintenance->asset->update(['status' => 'available']);
        } else {
            $maintenance->asset->update(['status' => 'in_repair']);
        }

        return redirect()->route('maintenance.index')->with('status', 'Maintenance ticket updated.');
    }
}