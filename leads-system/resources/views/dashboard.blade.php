@extends('layouts.app')

@section('content')
    @include('layouts.navbar')

    <div class="container py-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h2 class="mb-4">Dashboard</h2>

                <div class="mb-3">
                    <h5>Total Leads: <span class="badge bg-primary">{{ $totalLeads }}</span></h5>
                </div>

                <div class="mb-4">
                    <h5>Status-wise Breakdown</h5>
                    <ul class="list-group">
                        @foreach ($statusCounts as $status => $count)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $status }}
                                <span class="badge bg-secondary">{{ $count }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>

                @if (auth()->user()->role === 'sales')
                    <div class="alert alert-info">
                        <strong>Your Assigned Leads:</strong> {{ $userLeadsCount }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
