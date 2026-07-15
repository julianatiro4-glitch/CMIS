<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LocationRequest;
use App\Models\Location;
use Illuminate\Http\JsonResponse;

class LocationController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(
            Location::withCount('assets')->orderBy('name')->paginate(15)
        );
    }

    public function store(LocationRequest $request): JsonResponse
    {
        $location = Location::create($request->validated());

        return response()->json($location, 201);
    }

    public function show(Location $location): JsonResponse
    {
        return response()->json($location->loadCount('assets'));
    }

    public function update(LocationRequest $request, Location $location): JsonResponse
    {
        $location->update($request->validated());

        return response()->json($location);
    }

    public function destroy(Location $location): JsonResponse
    {
        if ($location->assets()->exists()) {
            return response()->json([
                'message' => 'Cannot delete a location that still has assets assigned to it.',
            ], 422);
        }

        $location->delete();

        return response()->json(['message' => 'Location deleted successfully.']);
    }
}
