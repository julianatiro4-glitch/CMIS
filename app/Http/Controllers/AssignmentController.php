<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssignmentRequest;
use App\Http\Requests\CheckInRequest;
use App\Models\Asset;
use App\Models\Assignment;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AssignmentController extends Controller
{
    public function index(): View
    {
        $assignments = Assignment::with(['asset', 'user', 'assignedBy'])
            ->latest('assigned_at')
            ->paginate(15);

        return view('assignments.index', ['assignments' => $assignments]);
    }

    public function create(): View
    {
        return view('assignments.create', [
            'assets' => Asset::where('status', 'available')->orderBy('name')->get(),
            'users' => User::orderBy('name')->get(),
        ]);
    }

    public function store(AssignmentRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['assigned_by'] = $request->user()?->id;

        $asset = Asset::findOrFail($data['asset_id']);

        if ($asset->status !== 'available') {
            return back()->with('error', 'This asset is not currently available to assign.');
        }

        Assignment::create($data);
        $asset->update(['status' => 'in_use']);

        return redirect()->route('assignments.index')->with('status', 'Asset checked out successfully.');
    }

    public function checkIn(CheckInRequest $request, Assignment $assignment): RedirectResponse
    {
        if ($assignment->returned_at) {
            return back()->with('error', 'This assignment has already been returned.');
        }

        $assignment->update([
            'returned_at' => now(),
            'condition_on_return' => $request->validated()['condition_on_return'] ?? null,
        ]);

        $assignment->asset->update(['status' => 'available']);

        return redirect()->route('assignments.index')->with('status', 'Asset checked in successfully.');
    }
}