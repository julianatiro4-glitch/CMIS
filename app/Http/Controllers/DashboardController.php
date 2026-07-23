<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\TechnicalSupport;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'total' => Asset::count(),
            'good' => Asset::where('condition', 'good')->count(),
            'fair' => Asset::where('condition', 'fair')->count(),
            'for_repair' => Asset::where('condition', 'for_repair')->count(),
            'unserviceable' => Asset::where('condition', 'unserviceable')->count(),
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

        $openTickets = TechnicalSupport::openOrInProgress()
            ->latest('date')
            ->limit(5)
            ->get();

        $expiringWarranties = Asset::query()
            ->whereNotNull('warranty_expiry')
            ->whereBetween('warranty_expiry', [now(), now()->addDays(60)])
            ->orderBy('warranty_expiry')
            ->limit(5)
            ->get();

        $attentionSummary = [
            'open_tickets' => TechnicalSupport::whereIn('status', ['open', 'in_progress'])->count(),
            'warranty_alerts' => $expiringWarranties->count(),
            'in_repair' => $stats['for_repair'],
        ];

        return view('dashboard.index', [
            'stats' => $stats,
            'byCategory' => $byCategory,
            'openTickets' => $openTickets,
            'expiringWarranties' => $expiringWarranties,
            'attentionSummary' => $attentionSummary,
        ]);
    }
}