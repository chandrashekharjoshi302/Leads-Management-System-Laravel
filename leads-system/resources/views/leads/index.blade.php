@extends('layouts.app')

@section('content')
    @include('layouts.navbar')

    <div style="padding: 30px; max-width: 1200px; margin: auto;">
        <h2 style="margin-bottom: 20px; font-size: 28px; color: #333;">All Leads</h2>

        <form method="GET" style="margin-bottom: 20px; display: flex; gap: 10px; flex-wrap: wrap; align-items: center;">
            <div>
                <label for="status">Status:</label><br>
                <select name="status" id="status" style="padding: 6px 10px; min-width: 150px;">
                    <option value="">All Status</option>
                    @foreach (['New', 'Contacted', 'Converted', 'Lost'] as $status)
                        <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                            {{ $status }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="lead_source">Lead Source:</label><br>
                <select name="lead_source" id="lead_source" style="padding: 6px 10px; min-width: 150px;">
                    <option value="">All Sources</option>
                    @foreach ($leads->pluck('lead_source')->unique() as $source)
                        <option value="{{ $source }}" {{ request('lead_source') == $source ? 'selected' : '' }}>
                            {{ $source }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <br>
                <button type="submit"
                    style="padding: 8px 16px; background-color: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer;">
                    Filter
                </button>
            </div>
        </form>

        @if (session('success'))
            <p style="color: green; margin-bottom: 15px;">{{ session('success') }}</p>
        @endif

        <div style="overflow-x:auto;">
            <table style="width: 100%; border-collapse: collapse; background-color: #fff;">
                <thead>
                    <tr style="background-color: #f2f2f2;">
                        <th style="padding: 10px; border: 1px solid #ddd;">Name</th>
                        <th style="padding: 10px; border: 1px solid #ddd;">Email</th>
                        <th style="padding: 10px; border: 1px solid #ddd;">Phone</th>
                        <th style="padding: 10px; border: 1px solid #ddd;">Source</th>
                        <th style="padding: 10px; border: 1px solid #ddd;">Status</th>
                        <th style="padding: 10px; border: 1px solid #ddd;">Assigned To</th>
                        <th style="padding: 10px; border: 1px solid #ddd;">Remarks</th>
                        <th style="padding: 10px; border: 1px solid #ddd;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($leads as $lead)
                        <tr>
                            <td style="padding: 10px; border: 1px solid #ddd;">{{ $lead->name }}</td>
                            <td style="padding: 10px; border: 1px solid #ddd;">{{ $lead->email }}</td>
                            <td style="padding: 10px; border: 1px solid #ddd;">{{ $lead->phone }}</td>
                            <td style="padding: 10px; border: 1px solid #ddd;">{{ $lead->lead_source }}</td>
                            <td style="padding: 10px; border: 1px solid #ddd;">{{ $lead->status }}</td>
                            <td style="padding: 10px; border: 1px solid #ddd;">{{ $lead->assignedUser->name ?? '-' }}</td>
                            <td style="padding: 10px; border: 1px solid #ddd;">{{ $lead->remarks }}</td>
                            <td style="padding: 10px; border: 1px solid #ddd;">
                                <a href="{{ route('leads.edit', $lead->id) }}"
                                    style="margin-right: 8px; color: #007bff;">Edit</a>
                                <a href="{{ route('leads.delete', $lead->id) }}" style="color: red;"
                                    onclick="return confirm('Are you sure?')">Delete</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="padding: 10px; border: 1px solid #ddd; text-align: center;">No leads
                                found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
