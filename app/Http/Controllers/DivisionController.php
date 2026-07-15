<?php

namespace App\Http\Controllers;

use App\Http\Requests\DivisionRequest;
use App\Models\Division;
use App\Models\Location;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DivisionController extends Controller
{
    public function index(): View
    {
        $divisions = Division::with('location')
            ->withCount('assets')
            ->orderBy('location_id')
            ->orderBy('name')
            ->paginate(15);

        return view('divisions.index', ['divisions' => $divisions]);
    }

    public function create(): View
    {
        return view('divisions.create', [
            'locations' => Location::orderBy('name')->get(),
        ]);
    }

    public function store(DivisionRequest $request): RedirectResponse
    {
        Division::create($request->validated());

        return redirect()->route('divisions.index')
            ->with('status', 'Division/Section created successfully.');
    }

    public function edit(Division $division): View
    {
        return view('divisions.edit', [
            'division'  => $division,
            'locations' => Location::orderBy('name')->get(),
        ]);
    }

    public function update(DivisionRequest $request, Division $division): RedirectResponse
    {
        $division->update($request->validated());

        return redirect()->route('divisions.index')
            ->with('status', 'Division/Section updated successfully.');
    }

    public function destroy(Division $division): RedirectResponse
    {
        if ($division->assets()->exists()) {
            return redirect()->route('divisions.index')
                ->with('error', 'Cannot delete a division that still has assets assigned to it.');
        }

        $division->delete();

        return redirect()->route('divisions.index')
            ->with('status', 'Division/Section deleted successfully.');
    }
}
