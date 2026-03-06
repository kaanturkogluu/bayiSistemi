<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use OwenIt\Auditing\Models\Audit;

class AuditController extends Controller
{
    public function index(Request $request)
    {
        $query = Audit::with('user')->orderBy('created_at', 'desc');

        // Optional filtering by event type or user could go here

        $audits = $query->paginate(20);

        return view('admin.audits.index', compact('audits'));
    }
}
