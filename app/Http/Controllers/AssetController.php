<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetHistory;
use App\Models\Maintenance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AssetsExport;
class AssetController extends Controller
{
    /**
     * Dashboard
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $department = $request->department;

        // Assets + Search + Department Filter
        $assets = Asset::when($search, function ($query) use ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%")
                  ->orWhere('serial_number', 'like', "%{$search}%")
                  ->orWhere('assigned_to', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        })
        ->when($department, function ($query) use ($department) {
            $query->where('department', $department);
        })
        ->latest()
        ->get();

        // Dashboard stats
            $totalAssets = Asset::count();

            $activeAssets = Asset::where('status', 'Active')->count();

            $faultyAssets = Asset::where('status', 'Faulty')->count();

            $totalMaintenance = Maintenance::count();

            $pendingMaintenance = Maintenance::where('status', 'Pending')->count();
        // Chart Data
        $chartData = Asset::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        $departmentChart = Asset::select('department', DB::raw('count(*) as total'))
            ->groupBy('department')
            ->pluck('total', 'department');

        return view('assets.index', compact(
            'assets',
            'totalAssets',
            'activeAssets',
            'faultyAssets',
            'totalMaintenance',
            'pendingMaintenance',
            'chartData',
            'departmentChart'
    ));
    }

    /**
     * Create form
     */
    public function create()
    {
        return view('assets.create');
    }

    /**
     * Store asset
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'department' => 'required|string|max:255',
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
            'department' => 'required|string|max:255',
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

    /**
     * History
     */
    public function history()
    {
        $histories = AssetHistory::with('asset')
            ->latest()
            ->get();

        return view('assets.history', compact('histories'));
    }

    /**
     * Delete asset
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

    /**
     * Department Report
     */
    public function departmentReport(Request $request, $department = null)
    {
        $department = $department ?? $request->department;

        if (!$department) {
            return redirect()->back()->with('error', 'Please select a department');
        }

        $assets = Asset::where('department', $department)->get();

        $total = $assets->count();
        $active = $assets->where('status', 'Active')->count();
        $faulty = $assets->where('status', 'Faulty')->count();
        $repair = $assets->where('status', 'In Repair')->count();

        $pdf = Pdf::loadView('assets.department_report', [
            'assets' => $assets,
            'department' => $department,
            'total' => $total,
            'active' => $active,
            'faulty' => $faulty,
            'repair' => $repair
        ]);

        return $pdf->download("{$department}-department-report.pdf");
    }
}
