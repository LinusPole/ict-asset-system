<?php

namespace App\Http\Controllers;

use App\Models\Maintenance;
use App\Models\Asset;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    /**
     * Display all maintenance records
     */
    public function index()
    {
        $maintenances = Maintenance::with('asset')
            ->latest()
            ->get();

        return view('maintenances.index', compact('maintenances'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        $assets = Asset::all();

        return view('maintenances.create', compact('assets'));
    }

    /**
     * Store maintenance record
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'asset_id' => 'required',
            'issue_reported' => 'required|string',
            'technician_assigned' => 'nullable|string',
            'status' => 'required|string',
            'repair_cost' => 'nullable|numeric',
            'reported_date' => 'required|date',
            'completed_date' => 'nullable|date',
            'remarks' => 'nullable|string',
        ]);

        $validated['reported_by'] = auth()->user()->name;

        Maintenance::create($validated);

        return redirect('/maintenances')
            ->with('success', 'Maintenance record added successfully');
    }
}