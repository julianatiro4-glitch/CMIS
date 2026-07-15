<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AssetRequest;
use App\Http\Resources\AssetResource;
use App\Models\Asset;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AssetController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $assets = Asset::query()
            ->with(['category', 'location'])
            ->search($request->query('q'))
            ->status($request->query('status'))
            ->when($request->query('category_id'), fn ($q, $id) => $q->where('category_id', $id))
            ->when($request->query('location_id'), fn ($q, $id) => $q->where('location_id', $id))
            ->latest()
            ->paginate($request->integer('per_page', 15));

        return AssetResource::collection($assets)->response();
    }

    public function store(AssetRequest $request): JsonResponse
    {
        $asset = Asset::create($request->validated());

        return (new AssetResource($asset->load(['category', 'location'])))
            ->response()
            ->setStatusCode(201);
    }

    public function show(Asset $asset): JsonResponse
    {
        return (new AssetResource($asset->load(['category', 'location'])))->response();
    }

    public function update(AssetRequest $request, Asset $asset): JsonResponse
    {
        $asset->update($request->validated());

        return (new AssetResource($asset->load(['category', 'location'])))->response();
    }

    public function destroy(Asset $asset): JsonResponse
    {
        $asset->delete();

        return response()->json(['message' => 'Asset deleted successfully.']);
    }
}
