<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $query = Lead::query();

        if ($user->role === 'sales') {
            $query->where('assigned_to', $user->id);
        }

        $totalLeads = $query->count();
        $statusCounts = $query->selectRaw('status, COUNT(*) as count')->groupBy('status')->pluck('count', 'status');
        $userLeadsCount = $user->role === 'sales' ? $totalLeads : 0;

        return view('dashboard', compact('totalLeads', 'statusCounts', 'userLeadsCount'));
    }
}
