<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Maintenance;
use App\Models\MaintenancePart;
use Illuminate\Support\Facades\Auth;

class UstaMaintenanceController extends Controller
{
    /**
     * List maintenances based on status
     */
    public function index(Request $request)
    {
        $status = $request->query('status', 'bekliyor'); // default to bekliyor
        $search = $request->query('search');

        $query = Maintenance::with(['customer', 'vehicle'])
            ->where('status', $status);

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('customer', function ($cq) use ($search) {
                    $cq->where('name_surname', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                })->orWhereHas('vehicle', function ($vq) use ($search) {
                    $vq->where('plate', 'like', "%{$search}%");
                });
            });
        }

        $maintenances = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.usta.maintenances', compact('maintenances', 'status', 'search'));
    }

    /**
     * Show maintenance details (parts list) for Usta
     */
    public function show(Maintenance $maintenance)
    {
        $maintenance->load(['customer', 'vehicle', 'parts.completedBy']);

        return view('admin.usta.show', compact('maintenance'));
    }

    /**
     * Toggle a single part's completion status
     */
    public function togglePart(Request $request, MaintenancePart $part)
    {
        // Toggle the status
        $part->is_completed = !$part->is_completed;

        // If completed, record who did it. If un-completed, clear it.
        if ($part->is_completed) {
            $part->completed_by = Auth::id();
        } else {
            $part->completed_by = null;
        }

        $part->save();

        $allCompleted = \App\Models\MaintenancePart::where('maintenance_id', $part->maintenance_id)
            ->where('is_completed', false)
            ->count() === 0;

        return response()->json([
            'success' => true,
            'is_completed' => $part->is_completed,
            'completed_by_name' => $part->is_completed ? Auth::user()->username : null,
            'all_completed' => $allCompleted
        ]);
    }

    /**
     * Mark the entire maintenance as completed
     */
    public function complete(Maintenance $maintenance)
    {
        // Check if all parts are actually completed
        $uncompletedParts = $maintenance->parts()->where('is_completed', false)->count();

        if ($uncompletedParts > 0) {
            return back()->with('error', 'Tüm parçalar işaretlenmeden bakım tamamlanamaz.');
        }

        $maintenance->status = 'tamamlandi';
        $maintenance->save();

        return redirect()->route('admin.usta.maintenances', ['status' => 'tamamlandi'])
            ->with('success', 'Bakım başarıyla tamamlandı olarak işaretlendi.');
    }
}
