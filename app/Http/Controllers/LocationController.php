<?php

namespace App\Http\Controllers;

use App\Http\Requests\LocationRequest;
use App\Models\Location;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class LocationController extends Controller
{
    public function index(): View
    {
        $locations = Location::withCount('assets')->orderBy('name')->paginate(15);

        return view('locations.index', ['locations' => $locations]);
    }

    public function create(): View
    {
        return view('locations.create');
    }

    public function store(LocationRequest $request): RedirectResponse
    {
        Location::create($request->validated());

        return redirect()->route('locations.index')->with('status', 'Location created successfully.');
    }

    public function edit(Location $location): View
    {
        return view('locations.edit', ['location' => $location]);
    }

    public function update(LocationRequest $request, Location $location): RedirectResponse
    {
        $location->update($request->validated());

        return redirect()->route('locations.index')->with('status', 'Location updated successfully.');
    }

    public function destroy(Location $location): RedirectResponse
    {
        if ($location->assets()->exists()) {
            return redirect()->route('locations.index')
                ->with('error', 'Cannot delete a location that still has assets assigned to it.');
        }

        $location->delete();

        return redirect()->route('locations.index')->with('status', 'Location deleted successfully.');
    }
}
