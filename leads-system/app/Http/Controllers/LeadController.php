<?php


namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\StreamedResponse;

class LeadController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Lead::query();

        if ($user->role === 'sales') {
            $query->where('assigned_to', $user->id);
        }

        // Filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('lead_source')) {
            $query->where('lead_source', $request->lead_source);
        }

        $leads = $query->latest()->get();

        return view('leads.index', compact('leads'));
    }

    public function create()
    {
        $users = User::where('role', 'sales')->get();
        return view('leads.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'lead_source' => 'required|string',
            'status' => 'required|string',
            'remarks' => 'nullable|string',
        ]);

        $lead = new Lead($validated);

        if (auth()->user()->role === 'admin') {
            $lead->assigned_to = $request->assigned_to;
        } else {
            $lead->assigned_to = auth()->id(); // Auto-assign to the logged-in sales executive
        }

        $lead->save();

        return redirect()->route('leads.index')->with('success', 'Lead created successfully.');
    }


    public function edit($id)
    {
        $lead = Lead::findOrFail($id);
        $this->authorizeLead($lead);

        $users = User::where('role', 'sales')->get();
        return view('leads.edit', compact('lead', 'users'));
    }

    public function update(Request $request, $id)
    {
        $lead = Lead::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'lead_source' => 'nullable|string',
            'status' => 'required|string',
            'remarks' => 'nullable|string',
        ]);

        // Only admins can update assigned_to
        if (auth()->user()->role === 'admin') {
            $data['assigned_to'] = $request->input('assigned_to');
        }

        $lead->update($data);

        return redirect()->route('leads.index')->with('success', 'Lead updated successfully.');
    }


    public function destroy($id)
    {
        $lead = Lead::findOrFail($id);
        $this->authorizeLead($lead);

        $lead->delete();

        return redirect()->route('leads.index')->with('success', 'Lead deleted successfully.');
    }

    public function export(): StreamedResponse
    {
        $leads = Lead::all();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="leads.csv"',
        ];

        $columns = ['Name', 'Email', 'Phone', 'Lead Source', 'Status', 'Assigned To', 'Remarks', 'Created At'];

        $callback = function () use ($leads, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($leads as $lead) {
                fputcsv($file, [
                    $lead->name,
                    $lead->email,
                    $lead->phone,
                    $lead->lead_source,
                    $lead->status,
                    $lead->assignedUser->name ?? '',
                    $lead->remarks,
                    $lead->created_at,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function authorizeLead($lead)
    {
        if (Auth::user()->role === 'sales' && $lead->assigned_to != Auth::id()) {
            abort(403, 'Unauthorized');
        }
    }
}
