<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Category;
use App\Models\Division;
use App\Models\TechnicalSupport;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function index(): View
    {
        // ── Condition breakdown ───────────────────────────────────
        $byCondition = collect(Asset::CONDITIONS)->mapWithKeys(fn ($c) => [
            $c => Asset::where('condition', $c)->count(),
        ]);

        // ── By division ───────────────────────────────────────────
        $byDivision = Division::withCount('assets')
            ->orderBy('code')
            ->get()
            ->map(fn ($d) => [
                'label' => $d->code ?? $d->name,
                'count' => $d->assets_count,
            ]);

        // ── By category ───────────────────────────────────────────
        $byCategory = Category::withCount('assets')
            ->whereHas('assets')
            ->orderByDesc('assets_count')
            ->get()
            ->map(fn ($c) => [
                'label' => $c->name,
                'count' => $c->assets_count,
            ]);

        // ── OS distribution ───────────────────────────────────────
        $byOS = Asset::selectRaw('operating_system, count(*) as total')
            ->whereNotNull('operating_system')
            ->groupBy('operating_system')
            ->orderByDesc('total')
            ->get()
            ->map(fn ($r) => ['label' => $r->operating_system, 'count' => $r->total]);

        // ── CrowdStrike coverage ──────────────────────────────────
        $totalComputers = Asset::whereIn('category_id',
            Category::whereIn('name', ['Desktop Computer', 'Laptop', 'Virtual Machine'])
                ->pluck('id')
        )->count();

        $withCrowdStrike = Asset::where('has_crowdstrike', true)->count();

        // ── Financial ─────────────────────────────────────────────
        $totalValue     = Asset::sum('purchase_cost');
        $avgValue       = Asset::whereNotNull('purchase_cost')->avg('purchase_cost');

        // ── Warranty alerts ───────────────────────────────────────
        $warrantyExpired = Asset::whereNotNull('warranty_expiry')
            ->where('warranty_expiry', '<', now())
            ->whereNotIn('status', ['retired', 'lost'])
            ->with(['division'])
            ->orderBy('warranty_expiry')
            ->get();

        $warrantyExpiring30 = Asset::whereNotNull('warranty_expiry')
            ->whereBetween('warranty_expiry', [now(), now()->addDays(30)])
            ->with(['division'])
            ->orderBy('warranty_expiry')
            ->get();

        $warrantyExpiring90 = Asset::whereNotNull('warranty_expiry')
            ->whereBetween('warranty_expiry', [now()->addDays(31), now()->addDays(90)])
            ->with(['division'])
            ->orderBy('warranty_expiry')
            ->get();

        // ── Maintenance summary ───────────────────────────────────
        $openTickets       = TechnicalSupport::where('status', 'open')->count();
        $inProgressTickets = TechnicalSupport::where('status', 'in_progress')->count();
        $resolvedTickets   = TechnicalSupport::where('status', 'resolved')->count();

        $avgResolutionDays = TechnicalSupport::where('status', 'resolved')
            ->whereNotNull('resolved_at')
            ->selectRaw('AVG(julianday(resolved_at) - julianday(date)) as avg_days')
            ->value('avg_days');

        return view('reports.index', compact(
            'byStatus', 'byCondition', 'byDivision', 'byCategory', 'byOS',
            'totalComputers', 'withCrowdStrike',
            'totalValue', 'avgValue',
            'warrantyExpired', 'warrantyExpiring30', 'warrantyExpiring90',
            'openTickets', 'inProgressTickets', 'resolvedTickets', 'avgResolutionDays',
        ));
    }
}
