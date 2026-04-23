<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AssetController extends Controller
{
    /**
     * Display asset dashboard
     */
    public function index(Request $request)
    {
        $search = $request->search;

        // Assets + Search
        $assets = Asset::when($search, function ($query) use ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%")
                  ->orWhere('serial_number', 'like', "%{$search}%")
                  ->orWhere('assigned_to', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        })->latest()->get();

        // Dashboard stats
        $totalAssets = Asset::count();
        $activeAssets = Asset::where('status', 'Active')->count();
        $faultyAssets = Asset::where('status', 'Faulty')->count();

        // CHART DATA (THIS IS THE FIX)
        $chartData = Asset::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        return view('assets.index', compact(
            'assets',
            'totalAssets',
            'activeAssets',
            'faultyAssets',
            'chartData'
        ));
    }

    /**
     * Show create form
     */
    public function create()
    {
        return view('assets.create');
    }

    /**
     * Store new asset
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'serial_number' => 'required|string|max:255|unique:assets',
            'status' => 'required|string',
            'assigned_to' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
        ]);

        Asset::create($validated);

        return redirect('/')->with('success', 'Asset added successfully');
    }

    /**
     * Edit asset
     */
    public function edit($id)
    {
        $asset = Asset::findOrFail($id);
        return view('assets.edit', compact('asset'));
    }

    /**
     * Update asset
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'serial_number' => 'required|string|max:255',
            'status' => 'required|string',
            'assigned_to' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
        ]);

        $asset = Asset::findOrFail($id);
        $asset->update($validated);

        return redirect('/')->with('success', 'Asset updated successfully');
    }

    /**
     * Delete asset (admin only)
     */
    public function destroy($id)
    {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized access');
        }

        $asset = Asset::findOrFail($id);
        $asset->delete();

        return redirect('/')->with('success', 'Asset deleted successfully');
    }
}