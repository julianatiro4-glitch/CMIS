<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Assignment;
use App\Models\MaintenanceRecord;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'total' => Asset::count(),
            'available' => Asset::where('status', 'available')->count(),
            'in_use' => Asset::where('status', 'in_use')->count(),
            'in_repair' => Asset::where('status', 'in_repair')->count(),
            'retired' => Asset::whereIn('status', ['retired', 'lost'])->count(),
        ];

        $byCategory = Asset::query()
            ->selectRaw('category_id, count(*) as total')
            ->groupBy('category_id')
            ->with('category')
            ->get()
            ->map(fn ($row) => [
                'label' => optional($row->category)->name ?? 'Uncategorized',
                'count' => (int) $row->total,
            ])
            ->sortByDesc('count')
            ->values();

        $activeAssignments = Assignment::with(['asset', 'user'])
            ->active()
            ->latest('assigned_at')
            ->limit(5)
            ->get();

        $openTickets = MaintenanceRecord::with('asset')
            ->openOrInProgress()
            ->latest('opened_at')
            ->limit(5)
            ->get();

        $expiringWarranties = Asset::query()
            ->whereNotNull('warranty_expiry')
            ->whereBetween('warranty_expiry', [now(), now()->addDays(60)])
            ->orderBy('warranty_expiry')
            ->limit(5)
            ->get();

        $attentionSummary = [
            'open_tickets' => MaintenanceRecord::whereIn('status', ['open', 'in_progress'])->count(),
            'warranty_alerts' => $expiringWarranties->count(),
            'in_repair' => $stats['in_repair'],
            'active_assignments' => $activeAssignments->count(),
        ];

        return view('dashboard.index', [
            'stats' => $stats,
            'byCategory' => $byCategory,
            'activeAssignments' => $activeAssignments,
            'openTickets' => $openTickets,
            'expiringWarranties' => $expiringWarranties,
            'attentionSummary' => $attentionSummary,
        ]);
    }
}