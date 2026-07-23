<?php

namespace App\Http\Controllers;

use App\Models\TechnicalSupport;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TechnicalSupportController extends Controller
{
    public function index(): View
    {
        $records = TechnicalSupport::latest('date')->paginate(15);

        return view('technical_support.index', ['records' => $records]);
    }

    public function create(): View
    {
        return view('technical_support.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'date' => 'required|date',
            'division' => 'nullable|string|max:255',
            'reported_by' => 'nullable|string|max:255',
            'issue_problem' => 'required|string',
            'action_taken' => 'nullable|string',
            'handled_by' => 'nullable|string|max:255',
            'status' => 'required|in:in_progress,for_checking,failed,done',
        ]);

        TechnicalSupport::create($data);

        return redirect()->route('technical_support.index')->with('status', 'Technical Support ticket opened.');
    }

    public function edit(TechnicalSupport $technical_support): View
    {
        return view('technical_support.edit', [
            'record' => $technical_support,
        ]);
    }

    public function update(Request $request, TechnicalSupport $technical_support): RedirectResponse
    {
        $data = $request->validate([
            'date' => 'required|date',
            'division' => 'nullable|string|max:255',
            'reported_by' => 'nullable|string|max:255',
            'issue_problem' => 'required|string',
            'action_taken' => 'nullable|string',
            'handled_by' => 'nullable|string|max:255',
            'status' => 'required|in:in_progress,for_checking,failed,done',
        ]);

        if ($data['status'] === 'done' && ! $technical_support->resolved_at) {
            $data['resolved_at'] = now();
        } elseif ($data['status'] !== 'done') {
            $data['resolved_at'] = null;
        }

        $technical_support->update($data);

        return redirect()->route('technical_support.index')->with('status', 'Technical Support ticket updated.');
    }

    public function destroy(TechnicalSupport $technical_support): RedirectResponse
    {
        $technical_support->delete();

        return redirect()->route('technical_support.index')->with('status', 'Technical Support ticket deleted.');
    }
}
