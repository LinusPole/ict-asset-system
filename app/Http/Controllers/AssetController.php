<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AssetsExport;

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

        // Chart Data
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

        $asset = Asset::create($validated);

        AssetHistory::create([
            'asset_id' => $asset->id,
            'action' => 'Created',
            'performed_by' => auth()->user()->name,
            'description' => 'New asset was added to the system',
        ]);

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

        AssetHistory::create([
            'asset_id' => $asset->id,
            'action' => 'Updated',
            'performed_by' => auth()->user()->name,
            'description' => 'Asset details were updated',
        ]);

        return redirect('/')->with('success', 'Asset updated successfully');
    }

    /**
     * Export PDF
     */
    public function exportPDF()
    {
        $assets = Asset::all();

        $pdf = Pdf::loadView('assets.pdf', compact('assets'));

        return $pdf->download('ict-assets-report.pdf');
    }

    /**
     * Export Excel
     */
    public function exportExcel()
    {
        return Excel::download(new AssetsExport, 'ict-assets-report.xlsx');
    }
    public function history()
{
    $histories = AssetHistory::with('asset')
        ->latest()
        ->get();

    return view('assets.history', compact('histories'));
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

        AssetHistory::create([
            'asset_id' => $asset->id,
            'action' => 'Deleted',
            'performed_by' => auth()->user()->name,
            'description' => 'Asset was deleted from the system',
        ]);

        $asset->delete();

        return redirect('/')->with('success', 'Asset deleted successfully');
    }
}