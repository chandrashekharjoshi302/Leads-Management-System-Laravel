@extends('layouts.app')

@section('content')
    <div
        style="max-width: 600px; margin: 50px auto; background: #f9f9f9; padding: 25px; border-radius: 8px; box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);">
        <h2 style="text-align: center; margin-bottom: 20px;">Edit Lead</h2>

        @if (session('success'))
            <div style="color: green; margin-bottom: 15px;">{{ session('success') }}</div>
        @endif

        <form action="{{ route('leads.update', $lead->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div style="margin-bottom: 15px;">
                <label for="name" style="font-weight: bold;">Name:</label>
                <input type="text" name="name" value="{{ old('name', $lead->name) }}" style="width: 100%; padding: 8px;"
                    required>
            </div>

            <div style="margin-bottom: 15px;">
                <label for="email" style="font-weight: bold;">Email:</label>
                <input type="email" name="email" value="{{ old('email', $lead->email) }}"
                    style="width: 100%; padding: 8px;">
            </div>

            <div style="margin-bottom: 15px;">
                <label for="phone" style="font-weight: bold;">Phone:</label>
                <input type="text" name="phone" value="{{ old('phone', $lead->phone) }}"
                    style="width: 100%; padding: 8px;">
            </div>

            <div style="margin-bottom: 15px;">
                <label for="lead_source" style="font-weight: bold;">Lead Source:</label>
                <input type="text" name="lead_source" value="{{ old('lead_source', $lead->lead_source) }}"
                    style="width: 100%; padding: 8px;">
            </div>

            <div style="margin-bottom: 15px;">
                <label for="status" style="font-weight: bold;">Status:</label>
                <select name="status" id="status" style="width: 100%; padding: 8px;" required>
                    <option value="New" {{ old('status', $lead->status) == 'New' ? 'selected' : '' }}>New</option>
                    <option value="Contacted" {{ old('status', $lead->status) == 'Contacted' ? 'selected' : '' }}>Contacted
                    </option>
                    <option value="Qualified" {{ old('status', $lead->status) == 'Qualified' ? 'selected' : '' }}>Qualified
                    </option>
                    <option value="Lost" {{ old('status', $lead->status) == 'Lost' ? 'selected' : '' }}>Lost</option>
                </select>
            </div>

            @php
                $currentUser = Auth::user();
            @endphp

            @if ($currentUser && $currentUser->role === 'admin')
                <div style="margin-bottom: 15px;">
                    <label for="assigned_to" style="font-weight: bold;">Assigned To:</label>
                    <select name="assigned_to" id="assigned_to" style="width: 100%; padding: 8px;">
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}"
                                {{ old('assigned_to', $lead->assigned_to) == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @endif

            <div style="margin-bottom: 15px;">
                <label for="remarks" style="font-weight: bold;">Remarks:</label>
                <textarea name="remarks" rows="3" style="width: 100%; padding: 8px;">{{ old('remarks', $lead->remarks) }}</textarea>
            </div>

            <button type="submit"
                style="padding: 10px 20px; background: #3490dc; color: white; border: none; border-radius: 4px;">Update
                Lead</button>
            <a href="{{ route('leads.index') }}" style="margin-left: 10px; color: #3490dc;">Back</a>
        </form>
    </div>
@endsection
