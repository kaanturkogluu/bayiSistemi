<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CariController extends Controller
{
    public function index(Request $request)
    {
        $query = Customer::withSum([
            'transactions as total_debt' => function ($q) {
                $q->where('type', 'debt');
            }
        ], 'amount')
            ->withSum([
                'transactions as total_paid' => function ($q) {
                    $q->where('type', 'payment');
                }
            ], 'amount')
            ->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name_surname', 'like', "%{$search}%")
                ->orWhere('phone', 'like', "%{$search}%");
        }

        // Filter by status
        $filter = $request->query('filter', 'all');
        if ($filter === 'indebted') {
            $query->where('balance', '>', 0);
        } elseif ($filter === 'clear') {
            $query->where('balance', '<=', 0);
        }

        $customers = $query->paginate(15)->withQueryString();
        $searchQuery = $request->search;

        // Summary stats
        $totalDebt = Customer::sum('balance');
        $inDebtCount = Customer::where('balance', '>', 0)->count();
        $clearCount = Customer::where('balance', '<=', 0)->count();

        return view('admin.cari.index', compact(
            'customers',
            'searchQuery',
            'filter',
            'totalDebt',
            'inDebtCount',
            'clearCount'
        ));
    }
}
